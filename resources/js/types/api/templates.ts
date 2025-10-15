import { User } from "..";
import { Template } from "../models";

export interface CreateTemplateRequest {
    name: string;
    description?: string;
    category: 'birthday' | 'anniversary' | 'holiday' | 'graduation' | 'wedding' | 'general';
    greeting_type: 'video' | 'audio' | 'text' | 'mixed';
    content_structure: Record<string, unknown>;
    is_premium?: boolean;
    price?: number;
}

export type UpdateTemplateRequest = Partial<CreateTemplateRequest>;

export interface TemplateResponse extends Template {
    creator?: User;
    usage_count: number;
    rating: number;
}

export interface TemplateListResponse {
    data: Template[];
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
}

export interface TemplateFilterRequest {
    category?: string;
    greeting_type?: string;
    is_premium?: boolean;
    search?: string;
    sort_by?: 'name' | 'created_at' | 'rating' | 'usage_count';
    sort_order?: 'asc' | 'desc';
}