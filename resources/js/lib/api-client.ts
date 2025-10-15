export interface ApiResponse<T = unknown> {
    data: T;
    message?: string;
    status: number;
}

export interface ApiError {
    message: string;
    errors?: Record<string, string[]>;
    status: number;
}

export class ApiClient {
    private baseUrl = '/api';

    private async request<T>(
        endpoint: string,
        options: RequestInit = {}
    ): Promise<ApiResponse<T>> {
        const url = `${this.baseUrl}${endpoint}`;
        
        const defaultHeaders: Record<string, string> = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            defaultHeaders['X-CSRF-TOKEN'] = csrfToken;
        }

        const config: RequestInit = {
            ...options,
            headers: {
                ...defaultHeaders,
                ...options.headers,
            },
            credentials: 'same-origin',
        };

        try {
            const response = await fetch(url, config);
            const data = await response.json();

            if (!response.ok) {
                const error: ApiError = {
                    message: data.message || 'Request failed',
                    errors: data.errors,
                    status: response.status,
                };
                throw error;
            }

            return {
                data: data.data || data,
                message: data.message,
                status: response.status,
            };
        } catch (error) {
            if (error instanceof Error && error.name === 'TypeError') {
                throw {
                    message: 'Network error - please check your connection',
                    status: 0,
                } as ApiError;
            }
            throw error;
        }
    }

    // HTTP Methods
    async get<T>(endpoint: string, params?: Record<string, unknown>): Promise<ApiResponse<T>> {
        let url = endpoint;

        if (params) {
            const searchParams = new URLSearchParams();
            Object.entries(params).forEach(([key, value]) => {
                if (value !== undefined && value !== null) {
                    searchParams.append(key, String(value));
                }
            });
            if (searchParams.toString()) {
                url += `?${searchParams.toString()}`;
            }
        }
        return this.request<T>(url, { method: 'GET' });
    }

    async post<T>(endpoint: string, data?: unknown, options?: { headers?: Record<string, string> }): Promise<ApiResponse<T>> {
        const isFormData = data instanceof FormData;
    
        return this.request<T>(endpoint, {
            method: 'POST',
            body: isFormData ? data : (data ? JSON.stringify(data) : undefined),
            headers: {
                ...(isFormData ? {} : { 'Content-Type': 'application/json' }),
                ...options?.headers,
            },
        });
    }

    async put<T>(endpoint: string, data?: unknown): Promise<ApiResponse<T>> {
        return this.request<T>(endpoint, {
            method: 'PUT',
            body: data ? JSON.stringify(data) : undefined,
        });
    }

    async patch<T>(endpoint: string, data?: unknown): Promise<ApiResponse<T>> {
        return this.request<T>(endpoint, {
            method: 'PATCH',
            body: data ? JSON.stringify(data) : undefined,
        });
    }

    async delete<T>(endpoint: string): Promise<ApiResponse<T>> {
        return this.request<T>(endpoint, { method: 'DELETE' });
    }
}

// Export a singleton instance
export const apiClient = new ApiClient();