import React from 'react';
import { useAuth } from '@/contexts/AuthContext';
import { useApi } from '@/hooks/use-api';
import { greetingsService } from '@/services/greetings-service';
import { GreetingListResponse } from '@/types/api/greetings';

export default function TestPage() {
    const { user, isAuthenticated } = useAuth();
    const { data: greetings, isLoading, error } = useApi<GreetingListResponse>(
        () => greetingsService.getGreetings(),
        []
    );

    return (
        <div className="p-8">
            <h1 className="text-2xl font-bold mb-4">API Integration Test</h1>
            
            <div className="mt-4 p-4 border rounded">
                <h2 className="text-lg font-semibold">Auth Status:</h2>
                <p>Authenticated: {isAuthenticated ? 'Yes' : 'No'}</p>
                {user && <p>User: {user.name} ({user.email})</p>}
            </div>

            <div className="mt-4 p-4 border rounded">
                <h2 className="text-lg font-semibold">Greetings API Test:</h2>
                {isLoading && <p>Loading...</p>}
                {error && <p className="text-red-500">Error: {error.message}</p>}
                {greetings && (
                    <div>
                        <p>Loaded {greetings.greetings?.length || 0} greetings</p>  {/* Update property name */}
                        <p>Greetings data structure working correctly!</p>
                    </div>
                )}
            </div>
        </div>
    );
}