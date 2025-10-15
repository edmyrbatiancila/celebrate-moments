import { User } from "..";
import { Media } from "./Media";
import { Template } from "./Template";

export interface Greeting {
    id: number;
    creator_id: number;
    title: string;
    description?: string;
    greeting_type: 'video' | 'audio' | 'text' | 'mixed';
    template_id?: number;
    content_data?: Record<string, unknown>;
    status: 'draft' | 'scheduled' | 'sent' | 'delivered';
    scheduled_at?: string;
    sent_at?: string;
    is_public: boolean;
    price?: number;
    created_at: string;
    updated_at: string;
    
    // Relationships
    creator?: User;
    template?: Template;
    media?: Media[];
    recipients?: GreetingRecipient[];
    
    // Computed properties
    recipient_count?: number;
    view_count?: number;
    is_scheduled?: boolean;
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
    created_at: string;
    updated_at: string;
    
    // Relationships
    recipient?: User;
}