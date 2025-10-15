import { apiClient } from "@/lib/api-client";
import { CreateGreetingRequest, GreetingListResponse, GreetingResponse, SendGreetingRequest, UpdateGreetingRequest } from "@/types/api/greetings";
import { Greeting } from "@/types/models";

export class GreetingsService {
    async getGreetings(page = 1, filters = {}): Promise<GreetingListResponse> {  // Add return type
        const params = { page: page.toString(), ...filters };
        const response = await apiClient.get<GreetingListResponse>(`/greetings`, params);  // Add generic type
        return response.data;
    }

    async getGreeting(id: number): Promise<GreetingResponse> {
        const response = await apiClient.get<GreetingResponse>(`/greetings/${id}`);
        return response.data;
    }

    async createGreeting(data: CreateGreetingRequest): Promise<Greeting> {
        const response = await apiClient.post<{ greeting: Greeting }>('/greetings', data);
        return response.data.greeting;
    }

    async updateGreeting(id: number, data: UpdateGreetingRequest): Promise<Greeting> {
        const response = await apiClient.put<{ greeting: Greeting }>(`/greetings/${id}`, data);
        return response.data.greeting;
    }

    async deleteGreeting(id: number): Promise<void> {
        await apiClient.delete(`/greetings/${id}`);
    }

    async sendGreeting(id: number, data: SendGreetingRequest): Promise<void> {
        await apiClient.post(`/greetings/${id}/send`, data);
    }
}

export const greetingsService = new GreetingsService();