import { User } from "..";

export interface Template {
    id: number;
    creator_id: number;
    name: string;
    description?: string;
    category: 'birthday' | 'anniversary' | 'holiday' | 'graduation' | 'wedding' | 'general';
    greeting_type: 'video' | 'audio' | 'text' | 'mixed';
    content_structure: Record<string, unknown>;
    is_premium: boolean;
    price?: number;
    is_active: boolean;
    created_at: string;
    updated_at: string;
    
    // Relationships
    creator?: User;
    
    // Computed properties (if needed from API)
    usage_count?: number;
    rating?: number;
}