export class ApiError extends Error {
    constructor(
        message: string,
        public status: number,
        public errors?: Record<string, string[]>,
    ) {
        super(message);
    }
}

function getCsrfToken(): string {
    const token = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    return token ?? '';
}

type JsonObject = Record<string, unknown>;

type ApiOptions = {
    method?: 'GET' | 'POST' | 'PUT' | 'PATCH' | 'DELETE';
    body?: JsonObject;
};

export async function apiRequest<T>(
    url: string,
    options: ApiOptions = {},
): Promise<T> {
    const method = options.method ?? 'GET';
    const hasBody = options.body !== undefined;
    const headers: Record<string, string> = {
        Accept: 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
    };

    if (hasBody) {
        headers['Content-Type'] = 'application/json';
    }

    const response = await fetch(url, {
        method,
        credentials: 'same-origin',
        headers,
        body: hasBody ? JSON.stringify(options.body) : undefined,
    });

    const contentType = response.headers.get('content-type') ?? '';
    const isJson = contentType.includes('application/json');
    const payload = isJson ? await response.json() : null;

    if (!response.ok) {
        throw new ApiError(
            (payload?.message as string | undefined) ??
                'API request failed',
            response.status,
            payload?.errors as Record<string, string[]> | undefined,
        );
    }

    return payload as T;
}
