import { authService } from "@/services/auth-service";
import { User } from "@/types";
import { AuthResponse, LoginRequest, RegisterRequest } from "@/types/api/auth";
import { createContext, ReactNode, useContext, useEffect, useState } from "react";

interface AuthContextType {
    user: User | null;
    isAuthenticated: boolean;
    isLoading: boolean;
    login: (credentials: LoginRequest) => Promise<AuthResponse>;
    register: (userData: RegisterRequest) => Promise<AuthResponse>;
    logout: () => Promise<void>;
    switchRole: (role: 'creator' | 'celebrant') => Promise<void>;
    refreshUser: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

interface AuthProviderProps {
    children: ReactNode;
}

export function AuthProvider({ children }: AuthProviderProps) {
    const [user, setUser] = useState<User | null>(null);
    const [isLoading, setIsLoading] = useState(true);

    const isAuthenticated = !!user;

    useEffect(() => {
        checkAuthStatus();
    }, []);

    const checkAuthStatus = async () => {
        try {
            const token = localStorage.getItem('auth_token');
            if (token) {
                const currentUser = await authService.getCurrentUser();
                setUser(currentUser);
            }
        } catch (error) {
            console.error('Auth check failed:', error);
            localStorage.removeItem('auth_token');
        } finally {
            setIsLoading(false);
        }
    };

    const login = async (credentials: LoginRequest): Promise<AuthResponse> => {
        const response = await authService.login(credentials);
        localStorage.setItem('auth_token', response.token);
        setUser(response.user);
        return response;
    };

    const register = async (userData: RegisterRequest): Promise<AuthResponse> => {
        const response = await authService.register(userData);
        localStorage.setItem('auth_token', response.token);
        setUser(response.user);
        return response;
    };

    const logout = async (): Promise<void> => {
        try {
            await authService.logout();
        } finally {
            localStorage.removeItem('auth_token');
            setUser(null);
        }
    };

    const switchRole = async (role: 'creator' | 'celebrant'): Promise<void> => {
        const updatedUser = await authService.switchRole({ role });
        setUser(updatedUser);
    };

    const refreshUser = async (): Promise<void> => {
        if (isAuthenticated) {
            const currentUser = await authService.getCurrentUser();
            setUser(currentUser);
        }
    };

    const value: AuthContextType = {
        user,
        isAuthenticated,
        isLoading,
        login,
        register,
        logout,
        switchRole,
        refreshUser,
    };

    return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (context === undefined) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
}