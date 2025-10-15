import { User } from "..";

export interface Review {
    id: number;
    reviewer_id: number;
    reviewee_id: number;
    greeting_id?: number;
    rating: number;
    comment?: string;
    is_anonymous: boolean;
    created_at: string;
    updated_at: string;
    
    // Relationships
    reviewer?: User;
    reviewee?: User;
    
    // Computed properties
    reviewer_name?: string;
    time_ago?: string;
}