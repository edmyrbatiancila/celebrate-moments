import { User } from "..";
import { Media } from "../models";

export interface UploadMediaRequest {
    file: File;
    media_type: 'image' | 'video' | 'audio' | 'document';
    alt_text?: string;
    description?: string;
    is_public?: boolean;
}

export interface UpdateMediaRequest {
    alt_text?: string;
    description?: string;
    is_public?: boolean;
}

export interface MediaResponse extends Media {
    user?: User;
    url: string;
    thumbnail_url?: string;
}

export interface MediaListResponse {
    data: Media[];
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
}