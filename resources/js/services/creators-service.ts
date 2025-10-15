import { apiClient } from "@/lib/api-client";
import { CreateCreatorProfileRequest, CreatorListResponse, CreatorProfileResponse, UpdateCreatorProfileRequest } from "@/types/api/creators";
import { CreatorProfile } from "@/types/models";

export class CreatorsService {
    async getCreators(page = 1, filters = {}): Promise<CreatorListResponse> {
        const params = { page: page.toString(), ...filters };
        const response = await apiClient.get<CreatorListResponse>(`/creator-profiles`, params);
        return response.data;
    }

    async getCreator(id: number): Promise<CreatorProfileResponse> {
        const response = await apiClient.get<CreatorProfileResponse>(`/creator-profiles/${id}`);
        return response.data;
    }

    async getMyProfile(): Promise<CreatorProfileResponse> {
        const response = await apiClient.get<CreatorProfileResponse>('/creator-profiles/my-profile');
        return response.data;
    }

    async createProfile(data: CreateCreatorProfileRequest): Promise<CreatorProfile> {
        const response = await apiClient.post<{ creator_profile: CreatorProfile }>('/creator-profiles', data);
        return response.data.creator_profile;
    }

    async updateProfile(data: UpdateCreatorProfileRequest): Promise<CreatorProfile> {
        const response = await apiClient.put<{ creator_profile: CreatorProfile }>('/creator-profiles/my-profile', data);
        return response.data.creator_profile;
    }
}

export const creatorsService = new CreatorsService();