import { useCallback, useEffect, useState } from "react";

interface UseApiState<T> {
    data: T | null;
    isLoading: boolean;
    error: Error | null;
}

export function useApi<T>(apiCall: () => Promise<T>, deps: unknown[] = []) {
    const [state, setState] = useState<UseApiState<T>>({
        data: null,
        isLoading: true,
        error: null,
    });

    const memoizedApiCall = useCallback(apiCall, deps);

    useEffect(() => {
        let isCancelled = false;

        const fetchData = async () => {
            try {
                setState(prev => ({ ...prev, isLoading: true, error: null }));
                const data = await memoizedApiCall();
                
                if (!isCancelled) {
                    setState({ data, isLoading: false, error: null });
                }
            } catch (error) {
                if (!isCancelled) {
                    setState({ data: null, isLoading: false, error: error as Error });
                }
            }
        };

        fetchData();

        return () => {
            isCancelled = true;
        };
    }, [memoizedApiCall]);

    return state;
}