<script lang="ts">
    import { onMount } from 'svelte';
    import AppHead from '@/components/AppHead.svelte';
    import AppLayout from '@/layouts/AppLayout.svelte';
    import { apiRequest, ApiError } from '@/lib/api';
    import { dashboard } from '@/routes';
    import type { BreadcrumbItem } from '@/types';

    type TabKey =
        | 'overview'
        | 'companies'
        | 'contacts'
        | 'opportunities'
        | 'quotes'
        | 'tasks'
        | 'tickets';
    type TaskColumnKey = 'todo' | 'doing' | 'done';

    type PaginatedResponse<T> = {
        data: T[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };

    type Company = {
        id: number;
        name: string;
        industry: string | null;
        phone: string | null;
        email: string | null;
        website: string | null;
        address: string | null;
        notes: string | null;
    };

    type Contact = {
        id: number;
        company_id: number;
        first_name: string;
        last_name: string;
        email: string | null;
        phone: string | null;
        title: string | null;
        notes: string | null;
        company?: { id: number; name: string };
    };

    type Opportunity = {
        id: number;
        company_id: number;
        title: string;
        stage: string;
        amount: string;
        close_date: string | null;
        notes: string | null;
        company?: { id: number; name: string };
    };

    type QuoteItem = {
        id: number;
        description: string;
        quantity: string;
        unit_price: string;
        discount_rate: string;
        tax_rate: string;
        line_subtotal: string;
        line_discount_total: string;
        line_tax_total: string;
        line_total: string;
    };

    type Quote = {
        id: number;
        company_id: number;
        opportunity_id: number | null;
        quote_number: string;
        currency: string;
        status: string;
        note: string | null;
        subtotal: string;
        discount_total: string;
        tax_total: string;
        grand_total: string;
        company?: { id: number; name: string } | null;
        opportunity?: { id: number; title: string } | null;
        items?: QuoteItem[];
    };

    type Task = {
        id: number;
        title: string;
        description: string | null;
        due_date: string | null;
        status: TaskColumnKey;
        sort_order: number;
        assignee?: { id: number; name: string } | null;
        company?: { id: number; name: string } | null;
    };

    type TicketMessage = {
        id: number;
        message: string;
        is_internal: boolean;
        created_at: string;
        user?: { id: number; name: string } | null;
    };

    type Ticket = {
        id: number;
        company_id: number | null;
        contact_id: number | null;
        assigned_to: number | null;
        subject: string;
        priority: string;
        status: string;
        company?: { id: number; name: string } | null;
        contact?: { id: number; first_name: string; last_name: string } | null;
        assigned_to_user?: { id: number; name: string } | null;
        messages?: TicketMessage[];
    };

    type DashboardMetrics = {
        tasks_due_today: number;
        open_tickets: number;
        pipeline_total: number;
        recent_activities: Array<{
            id: number;
            action: string;
            description: string;
            user: string | null;
            created_at: string | null;
        }>;
    };

    type PipelineSummary = {
        total_pipeline: number;
        stage_distribution: Record<string, number>;
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Panel',
            href: dashboard().url,
        },
    ];

    const tabList: Array<{ key: TabKey; label: string }> = [
        { key: 'overview', label: 'Genel Bakis' },
        { key: 'companies', label: 'Company CRUD' },
        { key: 'contacts', label: 'Contact CRUD' },
        { key: 'opportunities', label: 'Opportunity CRUD' },
        { key: 'quotes', label: 'Quote + PDF' },
        { key: 'tasks', label: 'Task Kanban' },
        { key: 'tickets', label: 'Ticket CRUD' },
    ];

    const opportunityStages = ['lead', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];
    const quoteStatuses = ['draft', 'sent', 'accepted', 'rejected'];
    const quoteCurrencies = ['TRY', 'USD', 'EUR'];
    const ticketPriorities = ['low', 'medium', 'high', 'urgent'];
    const ticketStatuses = ['open', 'waiting', 'closed'];
    const taskColumns: Array<{ key: TaskColumnKey; label: string }> = [
        { key: 'todo', label: 'Yapilacak' },
        { key: 'doing', label: 'Devam Eden' },
        { key: 'done', label: 'Tamamlandi' },
    ];

    const validTabs = new Set<TabKey>([
        'overview',
        'companies',
        'contacts',
        'opportunities',
        'quotes',
        'tasks',
        'tickets',
    ]);

    let activeTab = $state<TabKey>('overview');
    let notice = $state<{ type: 'success' | 'error'; text: string } | null>(null);
    let selectedTicket = $state<Ticket | null>(null);
    let ticketMessage = $state('');
    let draggedTaskId = $state<number | null>(null);

    let metrics = $state<DashboardMetrics>({
        tasks_due_today: 0,
        open_tickets: 0,
        pipeline_total: 0,
        recent_activities: [],
    });

    let pipelineSummary = $state<PipelineSummary>({
        total_pipeline: 0,
        stage_distribution: {},
    });

    let loading = $state({
        metrics: false,
        companies: false,
        contacts: false,
        opportunities: false,
        quotes: false,
        tasks: false,
        tickets: false,
    });

    let submitting = $state({
        company: false,
        contact: false,
        opportunity: false,
        quote: false,
        task: false,
        ticket: false,
        ticketMessage: false,
    });

    let companySearch = $state('');
    let contactSearch = $state('');
    let opportunitySearch = $state('');
    let quoteSearch = $state('');
    let ticketSearch = $state('');

    let companies = $state<PaginatedResponse<Company>>(emptyPaginator<Company>());
    let contacts = $state<PaginatedResponse<Contact>>(emptyPaginator<Contact>());
    let opportunities = $state<PaginatedResponse<Opportunity>>(emptyPaginator<Opportunity>());
    let quotes = $state<PaginatedResponse<Quote>>(emptyPaginator<Quote>());
    let tickets = $state<PaginatedResponse<Ticket>>(emptyPaginator<Ticket>());
    let companyOptions = $state<Company[]>([]);
    let contactOptions = $state<Contact[]>([]);
    let opportunityOptions = $state<Opportunity[]>([]);
    let tasksByColumn = $state<Record<TaskColumnKey, Task[]>>({
        todo: [],
        doing: [],
        done: [],
    });

    let companyForm = $state({
        id: null as number | null,
        name: '',
        industry: '',
        phone: '',
        email: '',
        website: '',
        address: '',
        notes: '',
    });

    let contactForm = $state({
        id: null as number | null,
        company_id: '',
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        title: '',
        notes: '',
    });

    let opportunityForm = $state({
        id: null as number | null,
        company_id: '',
        title: '',
        stage: 'lead',
        amount: '0',
        close_date: '',
        notes: '',
    });

    let taskForm = $state({
        id: null as number | null,
        title: '',
        description: '',
        due_date: '',
        status: 'todo' as TaskColumnKey,
    });

    let ticketForm = $state({
        id: null as number | null,
        company_id: '',
        contact_id: '',
        subject: '',
        priority: 'medium',
        status: 'open',
    });

    type QuoteFormItem = {
        description: string;
        quantity: string;
        unit_price: string;
        discount_rate: string;
        tax_rate: string;
    };

    type QuoteTotals = {
        subtotal: number;
        discount_total: number;
        tax_total: number;
        grand_total: number;
    };

    function createQuoteItem(): QuoteFormItem {
        return {
            description: '',
            quantity: '1',
            unit_price: '0',
            discount_rate: '0',
            tax_rate: '20',
        };
    }

    let quoteForm = $state({
        id: null as number | null,
        company_id: '',
        opportunity_id: '',
        currency: 'TRY',
        status: 'draft',
        note: '',
        items: [createQuoteItem()] as QuoteFormItem[],
    });

    function emptyPaginator<T>(): PaginatedResponse<T> {
        return {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        };
    }

    function setNotice(type: 'success' | 'error', text: string): void {
        notice = { type, text };
    }

    function isTabKey(value: string | null): value is TabKey {
        if (!value) {
            return false;
        }

        return validTabs.has(value as TabKey);
    }

    function getTabFromLocation(): TabKey {
        if (typeof window === 'undefined') {
            return 'overview';
        }

        const url = new URL(window.location.href);
        const requestedTab = url.searchParams.get('tab');

        return isTabKey(requestedTab) ? requestedTab : 'overview';
    }

    function syncTabToLocation(tab: TabKey): void {
        if (typeof window === 'undefined') {
            return;
        }

        const url = new URL(window.location.href);

        if (tab === 'overview') {
            url.searchParams.delete('tab');
        } else {
            url.searchParams.set('tab', tab);
        }

        window.history.replaceState(
            window.history.state,
            '',
            `${url.pathname}${url.search}${url.hash}`,
        );
    }

    function setActiveTab(tab: TabKey): void {
        activeTab = tab;
        syncTabToLocation(tab);
    }

    function clearNotice(): void {
        notice = null;
    }

    function getErrorMessage(error: unknown): string {
        if (error instanceof ApiError) {
            if (error.errors) {
                const firstField = Object.values(error.errors)[0];
                if (firstField && firstField.length > 0) {
                    return firstField[0];
                }
            }

            return error.message;
        }

        return 'Islem sirasinda beklenmeyen bir hata olustu.';
    }

    function formatCurrency(value: number, currency: string): string {
        return new Intl.NumberFormat('tr-TR', {
            style: 'currency',
            currency,
            maximumFractionDigits: 2,
        }).format(value);
    }

    function formatMoney(value: number): string {
        return formatCurrency(value, 'TRY');
    }

    function stageLabel(stage: string): string {
        const labels: Record<string, string> = {
            lead: 'Lead',
            qualified: 'Qualified',
            proposal: 'Proposal',
            negotiation: 'Negotiation',
            won: 'Won',
            lost: 'Lost',
        };

        return labels[stage] ?? stage;
    }

    function ticketLabel(status: string): string {
        const labels: Record<string, string> = {
            open: 'Acik',
            waiting: 'Beklemede',
            closed: 'Kapali',
        };

        return labels[status] ?? status;
    }

    function ticketPriorityLabel(priority: string): string {
        const labels: Record<string, string> = {
            low: 'Dusuk',
            medium: 'Orta',
            high: 'Yuksek',
            urgent: 'Acil',
        };

        return labels[priority] ?? priority;
    }

    function quoteStatusLabel(status: string): string {
        const labels: Record<string, string> = {
            draft: 'Taslak',
            sent: 'Gonderildi',
            accepted: 'Kabul Edildi',
            rejected: 'Reddedildi',
        };

        return labels[status] ?? status;
    }

    function toPositiveNumber(value: string, fallback = 0): number {
        const parsed = Number(value);
        if (!Number.isFinite(parsed)) {
            return fallback;
        }

        return Math.max(parsed, 0);
    }

    function roundMoney(value: number): number {
        return Math.round(value * 100) / 100;
    }

    function quotePreviewTotals(items: QuoteFormItem[]): QuoteTotals {
        let subtotal = 0;
        let discountTotal = 0;
        let taxTotal = 0;

        for (const item of items) {
            const quantity = Math.max(toPositiveNumber(item.quantity, 1), 0.01);
            const unitPrice = toPositiveNumber(item.unit_price, 0);
            const discountRate = Math.min(toPositiveNumber(item.discount_rate, 0), 100);
            const taxRate = Math.min(toPositiveNumber(item.tax_rate, 20), 100);

            const lineSubtotal = quantity * unitPrice;
            const lineDiscount = (lineSubtotal * discountRate) / 100;
            const taxableAmount = Math.max(lineSubtotal - lineDiscount, 0);
            const lineTax = (taxableAmount * taxRate) / 100;

            subtotal += lineSubtotal;
            discountTotal += lineDiscount;
            taxTotal += lineTax;
        }

        return {
            subtotal: roundMoney(subtotal),
            discount_total: roundMoney(discountTotal),
            tax_total: roundMoney(taxTotal),
            grand_total: roundMoney(subtotal - discountTotal + taxTotal),
        };
    }

    async function refreshDashboardData(): Promise<void> {
        await Promise.all([loadMetrics(), loadPipelineSummary()]);
    }

    async function loadMetrics(): Promise<void> {
        loading.metrics = true;
        clearNotice();

        try {
            metrics = await apiRequest<DashboardMetrics>('/api/dashboard/metrics');
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.metrics = false;
        }
    }

    async function loadPipelineSummary(): Promise<void> {
        try {
            pipelineSummary = await apiRequest<PipelineSummary>(
                '/api/opportunities/pipeline-summary',
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadSelectorOptions(): Promise<void> {
        try {
            const [companyResult, contactResult, opportunityResult] = await Promise.all([
                apiRequest<PaginatedResponse<Company>>('/api/companies?per_page=100'),
                apiRequest<PaginatedResponse<Contact>>('/api/contacts?per_page=100'),
                apiRequest<PaginatedResponse<Opportunity>>('/api/opportunities?per_page=100'),
            ]);

            companyOptions = companyResult.data;
            contactOptions = contactResult.data;
            opportunityOptions = opportunityResult.data;
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadCompanies(page = 1): Promise<void> {
        loading.companies = true;

        try {
            companies = await apiRequest<PaginatedResponse<Company>>(
                `/api/companies?per_page=8&page=${page}&q=${encodeURIComponent(companySearch)}`,
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.companies = false;
        }
    }

    function resetCompanyForm(): void {
        companyForm = {
            id: null,
            name: '',
            industry: '',
            phone: '',
            email: '',
            website: '',
            address: '',
            notes: '',
        };
    }

    function editCompany(company: Company): void {
        companyForm = {
            id: company.id,
            name: company.name,
            industry: company.industry ?? '',
            phone: company.phone ?? '',
            email: company.email ?? '',
            website: company.website ?? '',
            address: company.address ?? '',
            notes: company.notes ?? '',
        };

        setActiveTab('companies');
    }

    async function saveCompany(): Promise<void> {
        submitting.company = true;
        clearNotice();

        const payload = {
            name: companyForm.name,
            industry: companyForm.industry || null,
            phone: companyForm.phone || null,
            email: companyForm.email || null,
            website: companyForm.website || null,
            address: companyForm.address || null,
            notes: companyForm.notes || null,
        };

        try {
            if (companyForm.id) {
                await apiRequest(`/api/companies/${companyForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Company guncellendi.');
            } else {
                await apiRequest('/api/companies', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Company olusturuldu.');
            }

            resetCompanyForm();
            await Promise.all([
                loadCompanies(companies.current_page),
                loadSelectorOptions(),
                refreshDashboardData(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.company = false;
        }
    }

    async function removeCompany(companyId: number): Promise<void> {
        if (!confirm('Bu company kaydi silinsin mi?')) {
            return;
        }

        clearNotice();

        try {
            await apiRequest(`/api/companies/${companyId}`, {
                method: 'DELETE',
            });
            setNotice('success', 'Company silindi.');
            await Promise.all([
                loadCompanies(companies.current_page),
                loadSelectorOptions(),
                refreshDashboardData(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadContacts(page = 1): Promise<void> {
        loading.contacts = true;

        try {
            contacts = await apiRequest<PaginatedResponse<Contact>>(
                `/api/contacts?per_page=8&page=${page}&q=${encodeURIComponent(contactSearch)}`,
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.contacts = false;
        }
    }

    function resetContactForm(): void {
        contactForm = {
            id: null,
            company_id: '',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            title: '',
            notes: '',
        };
    }

    function editContact(contact: Contact): void {
        contactForm = {
            id: contact.id,
            company_id: String(contact.company_id),
            first_name: contact.first_name,
            last_name: contact.last_name,
            email: contact.email ?? '',
            phone: contact.phone ?? '',
            title: contact.title ?? '',
            notes: contact.notes ?? '',
        };

        setActiveTab('contacts');
    }

    async function saveContact(): Promise<void> {
        submitting.contact = true;
        clearNotice();

        const payload = {
            company_id: Number(contactForm.company_id),
            first_name: contactForm.first_name,
            last_name: contactForm.last_name,
            email: contactForm.email || null,
            phone: contactForm.phone || null,
            title: contactForm.title || null,
            notes: contactForm.notes || null,
        };

        try {
            if (contactForm.id) {
                await apiRequest(`/api/contacts/${contactForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Contact guncellendi.');
            } else {
                await apiRequest('/api/contacts', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Contact olusturuldu.');
            }

            resetContactForm();
            await Promise.all([
                loadContacts(contacts.current_page),
                loadSelectorOptions(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.contact = false;
        }
    }

    async function removeContact(contactId: number): Promise<void> {
        if (!confirm('Bu contact kaydi silinsin mi?')) {
            return;
        }

        try {
            await apiRequest(`/api/contacts/${contactId}`, {
                method: 'DELETE',
            });
            setNotice('success', 'Contact silindi.');
            await Promise.all([
                loadContacts(contacts.current_page),
                loadSelectorOptions(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadOpportunities(page = 1): Promise<void> {
        loading.opportunities = true;

        try {
            opportunities = await apiRequest<PaginatedResponse<Opportunity>>(
                `/api/opportunities?per_page=8&page=${page}&q=${encodeURIComponent(opportunitySearch)}`,
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.opportunities = false;
        }
    }

    function resetOpportunityForm(): void {
        opportunityForm = {
            id: null,
            company_id: '',
            title: '',
            stage: 'lead',
            amount: '0',
            close_date: '',
            notes: '',
        };
    }

    function editOpportunity(opportunity: Opportunity): void {
        opportunityForm = {
            id: opportunity.id,
            company_id: String(opportunity.company_id),
            title: opportunity.title,
            stage: opportunity.stage,
            amount: String(opportunity.amount ?? '0'),
            close_date: opportunity.close_date ?? '',
            notes: opportunity.notes ?? '',
        };

        setActiveTab('opportunities');
    }

    async function saveOpportunity(): Promise<void> {
        submitting.opportunity = true;
        clearNotice();

        const payload = {
            company_id: Number(opportunityForm.company_id),
            title: opportunityForm.title,
            stage: opportunityForm.stage,
            amount: Number(opportunityForm.amount),
            close_date: opportunityForm.close_date || null,
            notes: opportunityForm.notes || null,
        };

        try {
            if (opportunityForm.id) {
                await apiRequest(`/api/opportunities/${opportunityForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Opportunity guncellendi.');
            } else {
                await apiRequest('/api/opportunities', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Opportunity olusturuldu.');
            }

            resetOpportunityForm();
            await Promise.all([
                loadOpportunities(opportunities.current_page),
                loadPipelineSummary(),
                refreshDashboardData(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.opportunity = false;
        }
    }

    async function removeOpportunity(opportunityId: number): Promise<void> {
        if (!confirm('Bu opportunity kaydi silinsin mi?')) {
            return;
        }

        try {
            await apiRequest(`/api/opportunities/${opportunityId}`, {
                method: 'DELETE',
            });
            setNotice('success', 'Opportunity silindi.');
            await Promise.all([
                loadOpportunities(opportunities.current_page),
                loadPipelineSummary(),
                refreshDashboardData(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadQuotes(page = 1): Promise<void> {
        loading.quotes = true;

        try {
            quotes = await apiRequest<PaginatedResponse<Quote>>(
                `/api/quotes?per_page=8&page=${page}&q=${encodeURIComponent(quoteSearch)}`,
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.quotes = false;
        }
    }

    function resetQuoteForm(): void {
        quoteForm = {
            id: null,
            company_id: '',
            opportunity_id: '',
            currency: 'TRY',
            status: 'draft',
            note: '',
            items: [createQuoteItem()],
        };
    }

    function addQuoteItem(): void {
        quoteForm.items = [...quoteForm.items, createQuoteItem()];
    }

    function removeQuoteItem(index: number): void {
        if (quoteForm.items.length <= 1) {
            quoteForm.items = [createQuoteItem()];
            return;
        }

        quoteForm.items = quoteForm.items.filter((_, currentIndex) => currentIndex !== index);
    }

    async function editQuote(quote: Quote): Promise<void> {
        clearNotice();

        try {
            const detail = await apiRequest<Quote>(`/api/quotes/${quote.id}`);
            quoteForm = {
                id: detail.id,
                company_id: String(detail.company_id),
                opportunity_id: detail.opportunity_id ? String(detail.opportunity_id) : '',
                currency: detail.currency,
                status: detail.status,
                note: detail.note ?? '',
                items:
                    (detail.items?.length ?? 0) > 0
                        ? detail.items!.map((item) => ({
                              description: item.description,
                              quantity: String(item.quantity ?? '1'),
                              unit_price: String(item.unit_price ?? '0'),
                              discount_rate: String(item.discount_rate ?? '0'),
                              tax_rate: String(item.tax_rate ?? '20'),
                          }))
                        : [createQuoteItem()],
            };

            setActiveTab('quotes');
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function saveQuote(): Promise<void> {
        submitting.quote = true;
        clearNotice();

        const normalizedItems = quoteForm.items
            .map((item) => ({
                description: item.description.trim(),
                quantity: Math.max(toPositiveNumber(item.quantity, 1), 0.01),
                unit_price: toPositiveNumber(item.unit_price, 0),
                discount_rate: Math.min(toPositiveNumber(item.discount_rate, 0), 100),
                tax_rate: Math.min(toPositiveNumber(item.tax_rate, 20), 100),
            }))
            .filter((item) => item.description.length > 0);

        if (normalizedItems.length === 0) {
            setNotice('error', 'En az bir quote kalemi girin.');
            submitting.quote = false;
            return;
        }

        const payload = {
            company_id: Number(quoteForm.company_id),
            opportunity_id: quoteForm.opportunity_id ? Number(quoteForm.opportunity_id) : null,
            currency: quoteForm.currency,
            status: quoteForm.status,
            note: quoteForm.note.trim() || null,
            items: normalizedItems,
        };

        try {
            if (quoteForm.id) {
                await apiRequest(`/api/quotes/${quoteForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Quote guncellendi.');
            } else {
                await apiRequest('/api/quotes', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Quote olusturuldu.');
            }

            resetQuoteForm();
            await Promise.all([
                loadQuotes(quotes.current_page),
                refreshDashboardData(),
                loadSelectorOptions(),
            ]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.quote = false;
        }
    }

    async function removeQuote(quoteId: number): Promise<void> {
        if (!confirm('Bu quote kaydi silinsin mi?')) {
            return;
        }

        clearNotice();

        try {
            await apiRequest(`/api/quotes/${quoteId}`, {
                method: 'DELETE',
            });

            if (quoteForm.id === quoteId) {
                resetQuoteForm();
            }

            setNotice('success', 'Quote silindi.');
            await Promise.all([loadQuotes(quotes.current_page), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function exportQuotePdf(quoteId: number, quoteNumber: string): Promise<void> {
        clearNotice();

        try {
            const response = await fetch(`/api/quotes/${quoteId}/pdf`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/pdf,application/json',
                },
            });

            if (!response.ok) {
                const contentType = response.headers.get('content-type') ?? '';
                if (contentType.includes('application/json')) {
                    const payload = (await response.json()) as { message?: string };
                    setNotice('error', payload.message ?? 'PDF olusturulamadi.');
                } else {
                    setNotice('error', 'PDF olusturulamadi.');
                }
                return;
            }

            const blob = await response.blob();
            const fileUrl = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = fileUrl;
            link.download = `${quoteNumber}.pdf`;
            document.body.appendChild(link);
            link.click();
            link.remove();
            URL.revokeObjectURL(fileUrl);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadTasks(): Promise<void> {
        loading.tasks = true;

        try {
            const response = await apiRequest<Record<TaskColumnKey, Task[]>>(
                '/api/tasks?grouped=1',
            );
            tasksByColumn = {
                todo: response.todo ?? [],
                doing: response.doing ?? [],
                done: response.done ?? [],
            };
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.tasks = false;
        }
    }

    function resetTaskForm(): void {
        taskForm = {
            id: null,
            title: '',
            description: '',
            due_date: '',
            status: 'todo',
        };
    }

    function editTask(task: Task): void {
        taskForm = {
            id: task.id,
            title: task.title,
            description: task.description ?? '',
            due_date: task.due_date ?? '',
            status: task.status,
        };

        setActiveTab('tasks');
    }

    async function saveTask(): Promise<void> {
        submitting.task = true;
        clearNotice();

        const payload = {
            title: taskForm.title,
            description: taskForm.description || null,
            due_date: taskForm.due_date || null,
            status: taskForm.status,
        };

        try {
            if (taskForm.id) {
                await apiRequest(`/api/tasks/${taskForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Task guncellendi.');
            } else {
                await apiRequest('/api/tasks', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Task olusturuldu.');
            }

            resetTaskForm();
            await Promise.all([loadTasks(), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.task = false;
        }
    }

    async function removeTask(taskId: number): Promise<void> {
        if (!confirm('Bu task kaydi silinsin mi?')) {
            return;
        }

        try {
            await apiRequest(`/api/tasks/${taskId}`, {
                method: 'DELETE',
            });
            setNotice('success', 'Task silindi.');
            await Promise.all([loadTasks(), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    function handleTaskDragStart(event: DragEvent, taskId: number): void {
        draggedTaskId = taskId;
        event.dataTransfer?.setData('text/task-id', String(taskId));
        event.dataTransfer?.setData('text/plain', String(taskId));
        event.dataTransfer?.setDragImage((event.currentTarget as HTMLElement), 20, 20);
    }

    function handleTaskDragOver(event: DragEvent): void {
        event.preventDefault();
    }

    async function handleTaskDrop(event: DragEvent, status: TaskColumnKey): Promise<void> {
        event.preventDefault();

        const rawId = event.dataTransfer?.getData('text/task-id') ?? '';
        const taskId = Number(rawId || draggedTaskId);

        draggedTaskId = null;

        if (!taskId) {
            return;
        }

        try {
            await apiRequest(`/api/tasks/${taskId}/move`, {
                method: 'POST',
                body: {
                    status,
                    position: tasksByColumn[status].length,
                },
            });

            await Promise.all([loadTasks(), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function loadTickets(page = 1): Promise<void> {
        loading.tickets = true;

        try {
            tickets = await apiRequest<PaginatedResponse<Ticket>>(
                `/api/tickets?per_page=8&page=${page}&q=${encodeURIComponent(ticketSearch)}`,
            );
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            loading.tickets = false;
        }
    }

    async function openTicket(ticketId: number): Promise<void> {
        try {
            selectedTicket = await apiRequest<Ticket>(`/api/tickets/${ticketId}`);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    function resetTicketForm(): void {
        ticketForm = {
            id: null,
            company_id: '',
            contact_id: '',
            subject: '',
            priority: 'medium',
            status: 'open',
        };
    }

    function editTicket(ticket: Ticket): void {
        ticketForm = {
            id: ticket.id,
            company_id: ticket.company_id ? String(ticket.company_id) : '',
            contact_id: ticket.contact_id ? String(ticket.contact_id) : '',
            subject: ticket.subject,
            priority: ticket.priority,
            status: ticket.status,
        };

        setActiveTab('tickets');
    }

    async function saveTicket(): Promise<void> {
        submitting.ticket = true;
        clearNotice();

        const payload = {
            company_id: ticketForm.company_id ? Number(ticketForm.company_id) : null,
            contact_id: ticketForm.contact_id ? Number(ticketForm.contact_id) : null,
            subject: ticketForm.subject,
            priority: ticketForm.priority,
            status: ticketForm.status,
        };

        try {
            if (ticketForm.id) {
                await apiRequest(`/api/tickets/${ticketForm.id}`, {
                    method: 'PATCH',
                    body: payload,
                });
                setNotice('success', 'Ticket guncellendi.');
            } else {
                await apiRequest('/api/tickets', {
                    method: 'POST',
                    body: payload,
                });
                setNotice('success', 'Ticket olusturuldu.');
            }

            resetTicketForm();
            await Promise.all([loadTickets(tickets.current_page), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.ticket = false;
        }
    }

    async function removeTicket(ticketId: number): Promise<void> {
        if (!confirm('Bu ticket kaydi silinsin mi?')) {
            return;
        }

        try {
            await apiRequest(`/api/tickets/${ticketId}`, {
                method: 'DELETE',
            });
            if (selectedTicket?.id === ticketId) {
                selectedTicket = null;
            }
            setNotice('success', 'Ticket silindi.');
            await Promise.all([loadTickets(tickets.current_page), refreshDashboardData()]);
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        }
    }

    async function sendTicketMessage(): Promise<void> {
        if (!selectedTicket || !ticketMessage.trim()) {
            return;
        }

        submitting.ticketMessage = true;
        clearNotice();

        try {
            await apiRequest(`/api/tickets/${selectedTicket.id}/messages`, {
                method: 'POST',
                body: {
                    message: ticketMessage,
                    is_internal: false,
                },
            });

            ticketMessage = '';
            await Promise.all([
                openTicket(selectedTicket.id),
                refreshDashboardData(),
            ]);
            setNotice('success', 'Mesaj eklendi.');
        } catch (error) {
            setNotice('error', getErrorMessage(error));
        } finally {
            submitting.ticketMessage = false;
        }
    }

    onMount(async () => {
        setActiveTab(getTabFromLocation());

        await Promise.all([
            refreshDashboardData(),
            loadSelectorOptions(),
            loadCompanies(),
            loadContacts(),
            loadOpportunities(),
            loadQuotes(),
            loadTasks(),
            loadTickets(),
        ]);
    });
</script>

<AppHead title="CRM Paneli" />

<AppLayout {breadcrumbs}>
    <div class="space-y-6 p-4 md:p-6">
        {#if notice}
            <div
                class="rounded-xl border px-4 py-3 text-sm {notice.type === 'success'
                    ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                    : 'border-red-200 bg-red-50 text-red-700'}"
            >
                {notice.text}
            </div>
        {/if}

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
                <p class="text-xs tracking-wide text-slate-500 uppercase">Bugun Gorev</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{metrics.tasks_due_today}</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
                <p class="text-xs tracking-wide text-slate-500 uppercase">Acik Ticket</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{metrics.open_tickets}</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
                <p class="text-xs tracking-wide text-slate-500 uppercase">Pipeline Toplami</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{formatMoney(metrics.pipeline_total)}</p>
            </article>
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-xs">
                <p class="text-xs tracking-wide text-slate-500 uppercase">Toplam Pipeline</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{formatMoney(pipelineSummary.total_pipeline)}</p>
            </article>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="mb-4 flex flex-wrap gap-2">
                {#each tabList as tab (tab.key)}
                    <button
                        type="button"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition {activeTab === tab.key
                            ? 'border-slate-900 bg-slate-900 text-white'
                            : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100'}"
                        onclick={() => setActiveTab(tab.key)}
                    >
                        {tab.label}
                    </button>
                {/each}
            </div>

            {#if activeTab === 'overview'}
                <div class="grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <h2 class="text-lg font-semibold text-slate-900">Stage Dagilimi</h2>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            {#each opportunityStages as stage (stage)}
                                <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                    <p class="text-xs text-slate-500 uppercase">{stageLabel(stage)}</p>
                                    <p class="mt-1 text-lg font-semibold text-slate-900">
                                        {formatMoney(pipelineSummary.stage_distribution?.[stage] ?? 0)}
                                    </p>
                                </div>
                            {/each}
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <h2 class="text-lg font-semibold text-slate-900">Son Aktiviteler</h2>
                        <div class="mt-4 space-y-3">
                            {#if loading.metrics}
                                <p class="text-sm text-slate-500">Yukleniyor...</p>
                            {:else if metrics.recent_activities.length === 0}
                                <p class="text-sm text-slate-500">Henuz aktivite yok.</p>
                            {:else}
                                {#each metrics.recent_activities as activity (activity.id)}
                                    <article class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                                        <p class="text-sm font-medium text-slate-900">{activity.description}</p>
                                        <p class="mt-1 text-xs text-slate-500">
                                            {activity.user ?? 'Sistem'} - {activity.action}
                                        </p>
                                    </article>
                                {/each}
                            {/if}
                        </div>
                    </div>
                </div>
            {/if}

            {#if activeTab === 'companies'}
                <div class="grid gap-4 lg:grid-cols-2">
                    <section class="rounded-xl border border-slate-200 p-4">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <input
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-auto md:flex-1"
                                bind:value={companySearch}
                                placeholder="Company ara..."
                            />
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                onclick={() => loadCompanies(1)}
                            >
                                Ara
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-slate-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-100 text-left text-slate-600">
                                    <tr>
                                        <th class="px-3 py-2">Ad</th>
                                        <th class="px-3 py-2">Sektor</th>
                                        <th class="px-3 py-2">E-posta</th>
                                        <th class="px-3 py-2">Islem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {#if companies.data.length === 0}
                                        <tr>
                                            <td colspan="4" class="px-3 py-3 text-center text-slate-500">Kayit yok</td>
                                        </tr>
                                    {:else}
                                        {#each companies.data as company (company.id)}
                                            <tr class="border-t border-slate-200">
                                                <td class="px-3 py-2 font-medium text-slate-900">{company.name}</td>
                                                <td class="px-3 py-2 text-slate-600">{company.industry ?? '-'}</td>
                                                <td class="px-3 py-2 text-slate-600">{company.email ?? '-'}</td>
                                                <td class="px-3 py-2">
                                                    <div class="flex items-center gap-2">
                                                        <button
                                                            type="button"
                                                            class="rounded border border-slate-300 px-2 py-1 text-xs"
                                                            onclick={() => editCompany(company)}
                                                        >
                                                            Duzenle
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="rounded border border-red-300 px-2 py-1 text-xs text-red-600"
                                                            onclick={() => removeCompany(company.id)}
                                                        >
                                                            Sil
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {/each}
                                    {/if}
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Toplam: {companies.total}</span>
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50"
                                    onclick={() => loadCompanies(companies.current_page - 1)}
                                    disabled={companies.current_page <= 1}
                                >
                                    Onceki
                                </button>
                                <span>{companies.current_page} / {companies.last_page}</span>
                                <button
                                    type="button"
                                    class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50"
                                    onclick={() => loadCompanies(companies.current_page + 1)}
                                    disabled={companies.current_page >= companies.last_page}
                                >
                                    Sonraki
                                </button>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">
                            {companyForm.id ? 'Company Guncelle' : 'Yeni Company'}
                        </h3>
                        <form class="mt-3 space-y-3" onsubmit={(event) => { event.preventDefault(); void saveCompany(); }}>
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.name} placeholder="Company adi" required />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.industry} placeholder="Sektor" />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.phone} placeholder="Telefon" />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.email} placeholder="E-posta" />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.website} placeholder="Website" />
                            <textarea class="min-h-22 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.address} placeholder="Adres"></textarea>
                            <textarea class="min-h-22 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={companyForm.notes} placeholder="Not"></textarea>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.company}>
                                    {submitting.company ? 'Kaydediliyor...' : companyForm.id ? 'Guncelle' : 'Kaydet'}
                                </button>
                                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetCompanyForm}>Temizle</button>
                            </div>
                        </form>
                    </section>
                </div>
            {/if}

            {#if activeTab === 'contacts'}
                <div class="grid gap-4 lg:grid-cols-2">
                    <section class="rounded-xl border border-slate-200 p-4">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <input
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-auto md:flex-1"
                                bind:value={contactSearch}
                                placeholder="Contact ara..."
                            />
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                onclick={() => loadContacts(1)}
                            >
                                Ara
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-slate-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-100 text-left text-slate-600">
                                    <tr>
                                        <th class="px-3 py-2">Ad Soyad</th>
                                        <th class="px-3 py-2">Company</th>
                                        <th class="px-3 py-2">Unvan</th>
                                        <th class="px-3 py-2">Islem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {#if contacts.data.length === 0}
                                        <tr>
                                            <td colspan="4" class="px-3 py-3 text-center text-slate-500">Kayit yok</td>
                                        </tr>
                                    {:else}
                                        {#each contacts.data as contact (contact.id)}
                                            <tr class="border-t border-slate-200">
                                                <td class="px-3 py-2 font-medium text-slate-900">{contact.first_name} {contact.last_name}</td>
                                                <td class="px-3 py-2 text-slate-600">{contact.company?.name ?? '-'}</td>
                                                <td class="px-3 py-2 text-slate-600">{contact.title ?? '-'}</td>
                                                <td class="px-3 py-2">
                                                    <div class="flex items-center gap-2">
                                                        <button type="button" class="rounded border border-slate-300 px-2 py-1 text-xs" onclick={() => editContact(contact)}>Duzenle</button>
                                                        <button type="button" class="rounded border border-red-300 px-2 py-1 text-xs text-red-600" onclick={() => removeContact(contact.id)}>Sil</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {/each}
                                    {/if}
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Toplam: {contacts.total}</span>
                            <div class="flex items-center gap-2">
                                <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadContacts(contacts.current_page - 1)} disabled={contacts.current_page <= 1}>Onceki</button>
                                <span>{contacts.current_page} / {contacts.last_page}</span>
                                <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadContacts(contacts.current_page + 1)} disabled={contacts.current_page >= contacts.last_page}>Sonraki</button>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">{contactForm.id ? 'Contact Guncelle' : 'Yeni Contact'}</h3>
                        <form class="mt-3 space-y-3" onsubmit={(event) => { event.preventDefault(); void saveContact(); }}>
                            <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.company_id} required>
                                <option value="">Company secin</option>
                                {#each companyOptions as option (option.id)}
                                    <option value={String(option.id)}>{option.name}</option>
                                {/each}
                            </select>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.first_name} placeholder="Ad" required />
                                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.last_name} placeholder="Soyad" required />
                            </div>
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.email} placeholder="E-posta" />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.phone} placeholder="Telefon" />
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.title} placeholder="Unvan" />
                            <textarea class="min-h-22 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={contactForm.notes} placeholder="Not"></textarea>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.contact}>
                                    {submitting.contact ? 'Kaydediliyor...' : contactForm.id ? 'Guncelle' : 'Kaydet'}
                                </button>
                                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetContactForm}>Temizle</button>
                            </div>
                        </form>
                    </section>
                </div>
            {/if}

            {#if activeTab === 'opportunities'}
                <div class="grid gap-4 lg:grid-cols-2">
                    <section class="rounded-xl border border-slate-200 p-4">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-auto md:flex-1" bind:value={opportunitySearch} placeholder="Opportunity ara..." />
                            <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" onclick={() => loadOpportunities(1)}>Ara</button>
                        </div>
                        <div class="overflow-x-auto rounded-lg border border-slate-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-100 text-left text-slate-600">
                                    <tr>
                                        <th class="px-3 py-2">Baslik</th>
                                        <th class="px-3 py-2">Company</th>
                                        <th class="px-3 py-2">Stage</th>
                                        <th class="px-3 py-2">Tutar</th>
                                        <th class="px-3 py-2">Islem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {#if opportunities.data.length === 0}
                                        <tr><td colspan="5" class="px-3 py-3 text-center text-slate-500">Kayit yok</td></tr>
                                    {:else}
                                        {#each opportunities.data as opportunity (opportunity.id)}
                                            <tr class="border-t border-slate-200">
                                                <td class="px-3 py-2 font-medium text-slate-900">{opportunity.title}</td>
                                                <td class="px-3 py-2 text-slate-600">{opportunity.company?.name ?? '-'}</td>
                                                <td class="px-3 py-2 text-slate-600">{stageLabel(opportunity.stage)}</td>
                                                <td class="px-3 py-2 text-slate-600">{formatMoney(Number(opportunity.amount ?? 0))}</td>
                                                <td class="px-3 py-2">
                                                    <div class="flex items-center gap-2">
                                                        <button type="button" class="rounded border border-slate-300 px-2 py-1 text-xs" onclick={() => editOpportunity(opportunity)}>Duzenle</button>
                                                        <button type="button" class="rounded border border-red-300 px-2 py-1 text-xs text-red-600" onclick={() => removeOpportunity(opportunity.id)}>Sil</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {/each}
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Toplam: {opportunities.total}</span>
                            <div class="flex items-center gap-2">
                                <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadOpportunities(opportunities.current_page - 1)} disabled={opportunities.current_page <= 1}>Onceki</button>
                                <span>{opportunities.current_page} / {opportunities.last_page}</span>
                                <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadOpportunities(opportunities.current_page + 1)} disabled={opportunities.current_page >= opportunities.last_page}>Sonraki</button>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">{opportunityForm.id ? 'Opportunity Guncelle' : 'Yeni Opportunity'}</h3>
                        <form class="mt-3 space-y-3" onsubmit={(event) => { event.preventDefault(); void saveOpportunity(); }}>
                            <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.company_id} required>
                                <option value="">Company secin</option>
                                {#each companyOptions as option (option.id)}
                                    <option value={String(option.id)}>{option.name}</option>
                                {/each}
                            </select>
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.title} placeholder="Baslik" required />
                            <div class="grid gap-3 sm:grid-cols-2">
                                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.stage}>
                                    {#each opportunityStages as stage (stage)}
                                        <option value={stage}>{stageLabel(stage)}</option>
                                    {/each}
                                </select>
                                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.amount} type="number" min="0" step="0.01" placeholder="Tutar" required />
                            </div>
                            <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.close_date} type="date" />
                            <textarea class="min-h-22 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={opportunityForm.notes} placeholder="Not"></textarea>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.opportunity}>
                                    {submitting.opportunity ? 'Kaydediliyor...' : opportunityForm.id ? 'Guncelle' : 'Kaydet'}
                                </button>
                                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetOpportunityForm}>Temizle</button>
                            </div>
                        </form>
                    </section>
                </div>
            {/if}

            {#if activeTab === 'quotes'}
                <div class="grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
                    <section class="rounded-xl border border-slate-200 p-4">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <input
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-auto md:flex-1"
                                bind:value={quoteSearch}
                                placeholder="Quote no ara..."
                            />
                            <button
                                type="button"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                onclick={() => loadQuotes(1)}
                            >
                                Ara
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-slate-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-100 text-left text-slate-600">
                                    <tr>
                                        <th class="px-3 py-2">Quote No</th>
                                        <th class="px-3 py-2">Company</th>
                                        <th class="px-3 py-2">Durum</th>
                                        <th class="px-3 py-2">Toplam</th>
                                        <th class="px-3 py-2">Islem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {#if loading.quotes}
                                        <tr>
                                            <td colspan="5" class="px-3 py-3 text-center text-slate-500">Yukleniyor...</td>
                                        </tr>
                                    {:else if quotes.data.length === 0}
                                        <tr>
                                            <td colspan="5" class="px-3 py-3 text-center text-slate-500">Kayit yok</td>
                                        </tr>
                                    {:else}
                                        {#each quotes.data as quote (quote.id)}
                                            <tr class="border-t border-slate-200">
                                                <td class="px-3 py-2 font-medium text-slate-900">{quote.quote_number}</td>
                                                <td class="px-3 py-2 text-slate-600">{quote.company?.name ?? '-'}</td>
                                                <td class="px-3 py-2 text-slate-600">{quoteStatusLabel(quote.status)}</td>
                                                <td class="px-3 py-2 text-slate-600">
                                                    {formatCurrency(Number(quote.grand_total ?? 0), quote.currency)}
                                                </td>
                                                <td class="px-3 py-2">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <button
                                                            type="button"
                                                            class="rounded border border-slate-300 px-2 py-1 text-xs"
                                                            onclick={() => void editQuote(quote)}
                                                        >
                                                            Duzenle
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="rounded border border-amber-300 px-2 py-1 text-xs text-amber-700"
                                                            onclick={() => void exportQuotePdf(quote.id, quote.quote_number)}
                                                        >
                                                            PDF
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="rounded border border-red-300 px-2 py-1 text-xs text-red-600"
                                                            onclick={() => removeQuote(quote.id)}
                                                        >
                                                            Sil
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        {/each}
                                    {/if}
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                            <span>Toplam: {quotes.total}</span>
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50"
                                    onclick={() => loadQuotes(quotes.current_page - 1)}
                                    disabled={quotes.current_page <= 1}
                                >
                                    Onceki
                                </button>
                                <span>{quotes.current_page} / {quotes.last_page}</span>
                                <button
                                    type="button"
                                    class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50"
                                    onclick={() => loadQuotes(quotes.current_page + 1)}
                                    disabled={quotes.current_page >= quotes.last_page}
                                >
                                    Sonraki
                                </button>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">
                            {quoteForm.id ? 'Quote Guncelle' : 'Yeni Quote'}
                        </h3>
                        <form class="mt-3 space-y-3" onsubmit={(event) => { event.preventDefault(); void saveQuote(); }}>
                            <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={quoteForm.company_id} required>
                                <option value="">Company secin</option>
                                {#each companyOptions as company (company.id)}
                                    <option value={String(company.id)}>{company.name}</option>
                                {/each}
                            </select>

                            <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={quoteForm.opportunity_id}>
                                <option value="">Opportunity secin (opsiyonel)</option>
                                {#each opportunityOptions as opportunity (opportunity.id)}
                                    <option value={String(opportunity.id)}>{opportunity.title}</option>
                                {/each}
                            </select>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={quoteForm.currency}>
                                    {#each quoteCurrencies as currency (currency)}
                                        <option value={currency}>{currency}</option>
                                    {/each}
                                </select>

                                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={quoteForm.status}>
                                    {#each quoteStatuses as status (status)}
                                        <option value={status}>{quoteStatusLabel(status)}</option>
                                    {/each}
                                </select>
                            </div>

                            <textarea
                                class="min-h-22 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                bind:value={quoteForm.note}
                                placeholder="Quote notu"
                            ></textarea>

                            <div class="space-y-2 rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-slate-800">Kalemler</p>
                                    <button
                                        type="button"
                                        class="rounded border border-slate-300 px-2 py-1 text-xs"
                                        onclick={addQuoteItem}
                                    >
                                        Kalem Ekle
                                    </button>
                                </div>

                                {#each quoteForm.items as item, index (index)}
                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                        <div class="grid gap-2">
                                            <input
                                                class="w-full rounded border border-slate-300 px-2 py-1 text-sm"
                                                bind:value={item.description}
                                                placeholder="Aciklama"
                                            />
                                            <div class="grid gap-2 sm:grid-cols-2">
                                                <input
                                                    class="w-full rounded border border-slate-300 px-2 py-1 text-sm"
                                                    type="number"
                                                    min="0.01"
                                                    step="0.01"
                                                    bind:value={item.quantity}
                                                    placeholder="Adet"
                                                />
                                                <input
                                                    class="w-full rounded border border-slate-300 px-2 py-1 text-sm"
                                                    type="number"
                                                    min="0"
                                                    step="0.01"
                                                    bind:value={item.unit_price}
                                                    placeholder="Birim fiyat"
                                                />
                                            </div>
                                            <div class="grid gap-2 sm:grid-cols-2">
                                                <input
                                                    class="w-full rounded border border-slate-300 px-2 py-1 text-sm"
                                                    type="number"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    bind:value={item.discount_rate}
                                                    placeholder="Iskonto (%)"
                                                />
                                                <input
                                                    class="w-full rounded border border-slate-300 px-2 py-1 text-sm"
                                                    type="number"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    bind:value={item.tax_rate}
                                                    placeholder="KDV (%)"
                                                />
                                            </div>
                                            <div class="flex justify-end">
                                                <button
                                                    type="button"
                                                    class="rounded border border-red-300 px-2 py-1 text-xs text-red-600"
                                                    onclick={() => removeQuoteItem(index)}
                                                >
                                                    Kalemi Sil
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                {/each}
                            </div>

                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Ara Toplam</span>
                                    <strong>{formatCurrency(quotePreviewTotals(quoteForm.items).subtotal, quoteForm.currency)}</strong>
                                </div>
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="text-slate-600">Iskonto</span>
                                    <strong>{formatCurrency(quotePreviewTotals(quoteForm.items).discount_total, quoteForm.currency)}</strong>
                                </div>
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="text-slate-600">Vergi</span>
                                    <strong>{formatCurrency(quotePreviewTotals(quoteForm.items).tax_total, quoteForm.currency)}</strong>
                                </div>
                                <div class="mt-2 flex items-center justify-between border-t border-slate-200 pt-2 text-base">
                                    <span class="font-semibold text-slate-800">Genel Toplam</span>
                                    <strong>{formatCurrency(quotePreviewTotals(quoteForm.items).grand_total, quoteForm.currency)}</strong>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button
                                    type="submit"
                                    class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
                                    disabled={submitting.quote}
                                >
                                    {submitting.quote ? 'Kaydediliyor...' : quoteForm.id ? 'Guncelle' : 'Kaydet'}
                                </button>
                                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetQuoteForm}>Temizle</button>
                            </div>
                        </form>
                    </section>
                </div>
            {/if}

            {#if activeTab === 'tasks'}
                <div class="space-y-4">
                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">{taskForm.id ? 'Task Guncelle' : 'Yeni Task'}</h3>
                        <form class="mt-3 grid gap-3 md:grid-cols-4" onsubmit={(event) => { event.preventDefault(); void saveTask(); }}>
                            <input class="rounded-lg border border-slate-300 px-3 py-2 text-sm md:col-span-2" bind:value={taskForm.title} placeholder="Task basligi" required />
                            <input class="rounded-lg border border-slate-300 px-3 py-2 text-sm" type="date" bind:value={taskForm.due_date} />
                            <select class="rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={taskForm.status}>
                                {#each taskColumns as column (column.key)}
                                    <option value={column.key}>{column.label}</option>
                                {/each}
                            </select>
                            <textarea class="min-h-20 rounded-lg border border-slate-300 px-3 py-2 text-sm md:col-span-4" bind:value={taskForm.description} placeholder="Task aciklamasi"></textarea>
                            <div class="md:col-span-4 flex items-center gap-2">
                                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.task}>
                                    {submitting.task ? 'Kaydediliyor...' : taskForm.id ? 'Guncelle' : 'Kaydet'}
                                </button>
                                <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetTaskForm}>Temizle</button>
                            </div>
                        </form>
                    </section>

                    <section class="grid gap-4 lg:grid-cols-3">
                        {#each taskColumns as column (column.key)}
                            <article
                                class="rounded-xl border border-slate-200 bg-slate-50 p-4"
                                ondragover={handleTaskDragOver}
                                ondrop={(event) => void handleTaskDrop(event, column.key)}
                            >
                                <h4 class="text-sm font-semibold tracking-wide text-slate-700 uppercase">{column.label}</h4>
                                <div class="mt-3 space-y-3">
                                    {#if tasksByColumn[column.key].length === 0}
                                        <div class="rounded-lg border border-dashed border-slate-300 px-3 py-6 text-center text-xs text-slate-500">
                                            Kart yok. Surukle-birak ile tasiyabilirsin.
                                        </div>
                                    {:else}
                                        {#each tasksByColumn[column.key] as task (task.id)}
                                            <div
                                                class="cursor-grab rounded-lg border border-slate-200 bg-white p-3 shadow-xs"
                                                draggable="true"
                                                role="button"
                                                tabindex="0"
                                                ondragstart={(event) => handleTaskDragStart(event, task.id)}
                                            >
                                                <p class="text-sm font-medium text-slate-900">{task.title}</p>
                                                {#if task.description}
                                                    <p class="mt-1 text-xs text-slate-600">{task.description}</p>
                                                {/if}
                                                <div class="mt-3 flex items-center justify-between">
                                                    <span class="text-[11px] text-slate-500">
                                                        {task.due_date ? `Termin: ${task.due_date}` : 'Termin yok'}
                                                    </span>
                                                    <div class="flex items-center gap-2">
                                                        <button type="button" class="rounded border border-slate-300 px-2 py-1 text-[11px]" onclick={() => editTask(task)}>
                                                            Duzenle
                                                        </button>
                                                        <button type="button" class="rounded border border-red-300 px-2 py-1 text-[11px] text-red-600" onclick={() => removeTask(task.id)}>
                                                            Sil
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        {/each}
                                    {/if}
                                </div>
                            </article>
                        {/each}
                    </section>
                </div>
            {/if}

            {#if activeTab === 'tickets'}
                <div class="grid gap-4 lg:grid-cols-[1fr_1fr]">
                    <section class="space-y-4">
                        <article class="rounded-xl border border-slate-200 p-4">
                            <div class="mb-3 flex flex-wrap items-center gap-2">
                                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm md:w-auto md:flex-1" bind:value={ticketSearch} placeholder="Ticket ara..." />
                                <button type="button" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" onclick={() => loadTickets(1)}>Ara</button>
                            </div>
                            <div class="overflow-x-auto rounded-lg border border-slate-200">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-slate-100 text-left text-slate-600">
                                        <tr>
                                            <th class="px-3 py-2">Konu</th>
                                            <th class="px-3 py-2">Oncelik</th>
                                            <th class="px-3 py-2">Durum</th>
                                            <th class="px-3 py-2">Islem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {#if tickets.data.length === 0}
                                            <tr><td colspan="4" class="px-3 py-3 text-center text-slate-500">Kayit yok</td></tr>
                                        {:else}
                                            {#each tickets.data as ticket (ticket.id)}
                                                <tr class="border-t border-slate-200">
                                                    <td class="px-3 py-2 font-medium text-slate-900">{ticket.subject}</td>
                                                    <td class="px-3 py-2 text-slate-600">{ticketPriorityLabel(ticket.priority)}</td>
                                                    <td class="px-3 py-2 text-slate-600">{ticketLabel(ticket.status)}</td>
                                                    <td class="px-3 py-2">
                                                        <div class="flex flex-wrap items-center gap-2">
                                                            <button type="button" class="rounded border border-slate-300 px-2 py-1 text-xs" onclick={() => void openTicket(ticket.id)}>Detay</button>
                                                            <button type="button" class="rounded border border-slate-300 px-2 py-1 text-xs" onclick={() => editTicket(ticket)}>Duzenle</button>
                                                            <button type="button" class="rounded border border-red-300 px-2 py-1 text-xs text-red-600" onclick={() => removeTicket(ticket.id)}>Sil</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            {/each}
                                        {/if}
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                                <span>Toplam: {tickets.total}</span>
                                <div class="flex items-center gap-2">
                                    <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadTickets(tickets.current_page - 1)} disabled={tickets.current_page <= 1}>Onceki</button>
                                    <span>{tickets.current_page} / {tickets.last_page}</span>
                                    <button type="button" class="rounded border border-slate-300 px-2 py-1 disabled:opacity-50" onclick={() => loadTickets(tickets.current_page + 1)} disabled={tickets.current_page >= tickets.last_page}>Sonraki</button>
                                </div>
                            </div>
                        </article>

                        <article class="rounded-xl border border-slate-200 p-4">
                            <h3 class="text-base font-semibold text-slate-900">{ticketForm.id ? 'Ticket Guncelle' : 'Yeni Ticket'}</h3>
                            <form class="mt-3 space-y-3" onsubmit={(event) => { event.preventDefault(); void saveTicket(); }}>
                                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketForm.subject} placeholder="Ticket konusu" required />
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketForm.priority}>
                                        {#each ticketPriorities as priority (priority)}
                                            <option value={priority}>{ticketPriorityLabel(priority)}</option>
                                        {/each}
                                    </select>
                                    <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketForm.status}>
                                        {#each ticketStatuses as status (status)}
                                            <option value={status}>{ticketLabel(status)}</option>
                                        {/each}
                                    </select>
                                </div>
                                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketForm.company_id}>
                                    <option value="">Company secin (opsiyonel)</option>
                                    {#each companyOptions as option (option.id)}
                                        <option value={String(option.id)}>{option.name}</option>
                                    {/each}
                                </select>
                                <select class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketForm.contact_id}>
                                    <option value="">Contact secin (opsiyonel)</option>
                                    {#each contactOptions as option (option.id)}
                                        <option value={String(option.id)}>
                                            {option.first_name} {option.last_name}
                                        </option>
                                    {/each}
                                </select>
                                <div class="flex items-center gap-2">
                                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.ticket}>
                                        {submitting.ticket ? 'Kaydediliyor...' : ticketForm.id ? 'Guncelle' : 'Kaydet'}
                                    </button>
                                    <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm" onclick={resetTicketForm}>Temizle</button>
                                </div>
                            </form>
                        </article>
                    </section>

                    <section class="rounded-xl border border-slate-200 p-4">
                        <h3 class="text-base font-semibold text-slate-900">Ticket Mesaj Akisi</h3>
                        {#if !selectedTicket}
                            <p class="mt-3 rounded-lg border border-dashed border-slate-300 p-3 text-sm text-slate-500">
                                Mesaj akisini gormek icin listeden bir ticket secin.
                            </p>
                        {:else}
                            <div class="mt-3 space-y-3">
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                                    <p class="text-sm font-medium text-slate-900">{selectedTicket.subject}</p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        Durum: {ticketLabel(selectedTicket.status)} - Oncelik: {ticketPriorityLabel(selectedTicket.priority)}
                                    </p>
                                </div>
                                <div class="max-h-92 space-y-3 overflow-y-auto pr-1">
                                    {#if (selectedTicket.messages ?? []).length === 0}
                                        <p class="text-sm text-slate-500">Henuz mesaj yok.</p>
                                    {:else}
                                        {#each selectedTicket.messages ?? [] as message (message.id)}
                                            <article class="rounded-lg border border-slate-200 bg-white p-3">
                                                <p class="text-sm text-slate-800">{message.message}</p>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {message.user?.name ?? 'Bilinmiyor'} - {message.created_at}
                                                </p>
                                            </article>
                                        {/each}
                                    {/if}
                                </div>
                                <form class="space-y-2" onsubmit={(event) => { event.preventDefault(); void sendTicketMessage(); }}>
                                    <textarea class="min-h-24 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" bind:value={ticketMessage} placeholder="Mesajinizi yazin..." required></textarea>
                                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white disabled:opacity-50" disabled={submitting.ticketMessage}>
                                        {submitting.ticketMessage ? 'Gonderiliyor...' : 'Mesaj Gonder'}
                                    </button>
                                </form>
                            </div>
                        {/if}
                    </section>
                </div>
            {/if}
        </section>
    </div>
</AppLayout>
