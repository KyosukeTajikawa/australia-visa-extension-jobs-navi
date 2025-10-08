import '@inertiajs/core';

declare module '@inertiajs/core' {
    // アプリ内のユーザー型（必要に応じて項目追加）
    export type User = {
        id: number;
        name: string;
        nickname?: string;
    };

    // Inertia の PageProps を拡張（null を許可）
    interface PageProps {
        auth: { user: User | null };
    }
}
