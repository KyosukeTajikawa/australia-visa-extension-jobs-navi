import React from 'react';
import { Link } from '@inertiajs/react';

type Props = {
    children: React.ReactNode;
};

export default function GuestLayout({ children }: Props) {
    return (
        <div className="min-h-screen flex flex-col justify-center items-center bg-gray-100">
            <div>
                <Link href="/">
                    <h1 className="text-2xl font-bold mb-6">MyApp</h1>
                </Link>
            </div>

            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}

