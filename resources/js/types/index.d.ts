import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';
import { CreatorProfile } from './models/CreatorProfile';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    timezone?: string;
    email_verified_at: string | null;

    // Dual-role system fields
    is_creator: boolean;
    is_verified_creator: boolean;
    current_role: 'creator' | 'celebrant';
    date_of_birth: string;
    created_upgraded_at?: string | null;

    // Two-factor authentication
    two_factor_enabled?: boolean;

    created_at: string;
    updated_at: string;

    // Relationships
    creator_profile?: CreatorProfile;

    [key: string]: unknown; // This allows for additional properties...
}
