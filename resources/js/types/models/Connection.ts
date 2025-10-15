import { User } from "..";

export interface Connection {
    id: number;
    requester_id: number;
    receiver_id: number;
    status: 'pending' | 'accepted' | 'blocked';
    created_at: string;
    updated_at: string;
    
    // Relationships
    requester?: User;
    receiver?: User;
    
    // Computed properties
    other_user?: User;
    is_pending?: boolean;
    is_accepted?: boolean;
}