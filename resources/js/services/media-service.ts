import { apiClient } from "@/lib/api-client";
import { MediaListResponse, MediaResponse, UpdateMediaRequest, UploadMediaRequest } from "@/types/api/media";
import { Media } from "@/types/models";

export class MediaService {
    async getMedia(page = 1, filters = {}): Promise<MediaListResponse> {
        const params = { page: page.toString(), ...filters };
        const response = await apiClient.get<MediaListResponse>(`/media`, params);
        return response.data;
    }

    async getMediaItem(id: number): Promise<MediaResponse> {
        const response = await apiClient.get<MediaResponse>(`/media/${id}`);
        return response.data;
    }

    async uploadMedia(data: UploadMediaRequest): Promise<Media> {
        const formData = new FormData();
        formData.append('file', data.file);
        formData.append('media_type', data.media_type);
        if (data.alt_text) formData.append('alt_text', data.alt_text);
        if (data.description) formData.append('description', data.description);
        if (data.is_public !== undefined) formData.append('is_public', data.is_public.toString());

        const response = await apiClient.post<{ media: Media }>('/media', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        
        return response.data.media;
    }

    async updateMedia(id: number, data: UpdateMediaRequest): Promise<Media> {
        const response = await apiClient.put<{ media: Media }>(`/media/${id}`, data);
        return response.data.media;
    }

    async deleteMedia(id: number): Promise<void> {
        await apiClient.delete(`/media/${id}`);
    }
}

export const mediaService = new MediaService();