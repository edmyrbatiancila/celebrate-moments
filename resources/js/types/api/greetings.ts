import { User } from "..";
import { Media, Template } from "../models";

export interface CreateGreetingRequest {
    title: string;
    description?: string;
    greeting_type: 'video' | 'audio' | 'text' | 'mixed';
    template_id?: number;
    content_data?: Record<string, unknown>;
    theme_settings?: Record<string, unknown>;
    recipients: number[]; // Array of user IDs
    scheduled_at?: string;
    media_ids?: number[];
}

export type UpdateGreetingRequest = Partial<CreateGreetingRequest>;

export interface GreetingResponse {
    id: number;
    creator_id: number;
    title: string;
    description?: string;
    greeting_type: 'video' | 'audio' | 'text' | 'mixed';
    status: 'draft' | 'scheduled' | 'sent' | 'delivered' | 'viewed';
    template_id?: number;
    content_data?: Record<string, unknown>;
    theme_settings?: Record<string, unknown>;
    scheduled_at?: string;
    sent_at?: string;
    created_at: string;
    updated_at: string;
    
    // Relationships
    creator: User;
    template?: Template;
    media: Media[];
    recipients: GreetingRecipient[];
    analytics?: GreetingAnalytics;
}

export interface GreetingRecipient {
    id: number;
    greeting_id: number;
    recipient_id: number;
    sent_at?: string;
    delivered_at?: string;
    viewed_at?: string;
    is_thanked: boolean;
    thank_you_message?: string;
    
    // Relationships
    recipient: User;
}

export interface GreetingAnalytics {
    id: number;
    greeting_id: number;
    views_count: number;
    shares_count: number;
    likes_count: number;
    downloads_count: number;
}

export interface SendGreetingRequest {
    greeting_id: number;
    recipients?: number[];
    scheduled_at?: string;
}

export interface GreetingListResponse {
    greetings: GreetingResponse[];
}