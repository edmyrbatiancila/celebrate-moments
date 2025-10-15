import { apiClient } from "@/lib/api-client";
import { User } from "@/types";
import { AuthResponse, LoginRequest, RegisterRequest, SwitchRoleRequest, UpgradeToCreatorRequest } from "@/types/api/auth";

export class AuthService {
    async login(credentials: LoginRequest): Promise<AuthResponse> {
        const response = await apiClient.post<AuthResponse>('/auth/login', credentials);
        return response.data;
    }

    async register(userData: RegisterRequest): Promise<AuthResponse> {
        const response = await apiClient.post<AuthResponse>('/auth/register', userData);
        return response.data;
    }

    async logout(): Promise<void> {
        await apiClient.post('/auth/logout');
    }

    async getCurrentUser(): Promise<User> {
        const response = await apiClient.get<User>('/auth/user');
        return response.data;
    }

    async switchRole(roleData: SwitchRoleRequest): Promise<User> {
        const response = await apiClient.post<{ user: User }>('/auth/switch-role', roleData);
        return response.data.user;
    }

    async upgradeToCreator(data: UpgradeToCreatorRequest): Promise<User> {
        const response = await apiClient.post<{ user: User }>('/auth/upgrade-to-creator', data);
        return response.data.user;
    }
}

export const authService = new AuthService();