import { User } from "..";

export interface Media {
    id: number;
    user_id: number;
    filename: string;
    original_filename: string;
    file_path: string;
    file_size: number;
    mime_type: string;
    media_type: 'image' | 'video' | 'audio' | 'document';
    alt_text?: string;
    description?: string;
    is_public: boolean;
    created_at: string;
    updated_at: string;
    
    // Relationships
    user?: User;
    
    // Computed properties
    url?: string;
    thumbnail_url?: string;
    formatted_size?: string;
}