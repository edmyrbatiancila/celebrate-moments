import { apiClient } from "@/lib/api-client";
import { CreateTemplateRequest, TemplateFilterRequest, TemplateListResponse, TemplateResponse, UpdateTemplateRequest } from "@/types/api/templates";
import { Template } from "@/types/models";

export class TemplatesService {
    async getTemplates(filters: TemplateFilterRequest = {}): Promise<TemplateListResponse> {
        const response = await apiClient.get<TemplateListResponse>('/templates', { params: filters });
        return response.data;
    }

    async getTemplate(id: number): Promise<TemplateResponse> {
        const response = await apiClient.get<TemplateResponse>(`/templates/${id}`);
        return response.data;
    }

    async createTemplate(data: CreateTemplateRequest): Promise<Template> {
        const response = await apiClient.post<{ template: Template }>('/templates', data);
        return response.data.template;
    }

    async updateTemplate(id: number, data: UpdateTemplateRequest): Promise<Template> {
        const response = await apiClient.put<{ template: Template }>(`/templates/${id}`, data);
        return response.data.template;
    }

    async deleteTemplate(id: number): Promise<void> {
        await apiClient.delete(`/templates/${id}`);
    }

    async getRecommendations(occasion?: string) {
        const params = occasion ? { occasion } : {};
        const response = await apiClient.get('/templates/recommendations', params);
        return response.data;
    }
}

export const templatesService = new TemplatesService();