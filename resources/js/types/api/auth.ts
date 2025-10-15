import { User } from "..";
import { CreatorProfile } from "../models/CreatorProfile";

export interface LoginRequest {
    email: string;
    password: string;
}

export interface RegisterRequest {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    is_creator?: boolean;
}

export interface AuthResponse {
    user: User;
    token: string;
    message: string;
}

export interface UserProfileResponse extends User {
    creator_profile?: CreatorProfile;
}

// Add role switching interfaces
export interface SwitchRoleRequest {
    role: 'creator' | 'celebrant';
}

export interface UpgradeToCreatorRequest {
    bio?: string;
    specialties?: string[];
    portfolio_images?: string[];
    social_links?: Record<string, string>;
}

