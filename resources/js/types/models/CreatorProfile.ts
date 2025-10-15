import { User } from "..";

export interface CreatorProfile {
    id: number;
    user_id: number;
    bio?: string;
    specialties: string[];
    portfolio_images: string[];
    social_links: Record<string, string>;
    is_verified: boolean;
    verification_status: 'pending' | 'approved' | 'rejected';
    verification_submitted_at?: string | null;
    verification_notes?: string | null;
    subscription_tier: 'free' | 'basic' | 'premium';
    rating: number;
    total_reviews: number;
    created_at: string;
    updated_at: string;
    
    // Relationships
    user?: User;
}