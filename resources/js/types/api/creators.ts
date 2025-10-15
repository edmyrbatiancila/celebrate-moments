import { User } from "..";
import { Review } from "../models";
import { CreatorProfile } from "../models/CreatorProfile";

export interface CreateCreatorProfileRequest {
    bio?: string;
    specialties?: string[];
    portfolio_images?: string[];
    social_links?: Record<string, string>;
}

export type UpdateCreatorProfileRequest = Partial<CreateCreatorProfileRequest>;

export interface CreatorProfileResponse extends CreatorProfile {
    user: User;
    total_greetings: number;
    total_earnings: number;
    recent_reviews: Review[];
}

export interface CreatorListResponse {
    data: CreatorProfile[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

export interface CreatorVerificationRequest {
    profile_id: number;
    status: 'approved' | 'rejected';
    notes?: string;
}