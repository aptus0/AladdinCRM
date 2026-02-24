import dashboard from './dashboard'
import system from './system'
import opportunities from './opportunities'
import tasks from './tasks'
import tickets from './tickets'
import quotes from './quotes'
import companies from './companies'
import contacts from './contacts'

const api = {
    dashboard: Object.assign(dashboard, dashboard),
    system: Object.assign(system, system),
    opportunities: Object.assign(opportunities, opportunities),
    tasks: Object.assign(tasks, tasks),
    tickets: Object.assign(tickets, tickets),
    quotes: Object.assign(quotes, quotes),
    companies: Object.assign(companies, companies),
    contacts: Object.assign(contacts, contacts),
}

export default api