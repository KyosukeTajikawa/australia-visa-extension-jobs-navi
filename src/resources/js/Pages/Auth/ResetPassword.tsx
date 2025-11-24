import React from "react";
import { Head, useForm } from "@inertiajs/react";
import {Box,Heading,Text,FormControl,FormLabel,FormErrorMessage,Input,Button,VStack,} from "@chakra-ui/react";
import MainLayout from "@/Layouts/MainLayout";

type ResetPasswordProps = {
    token: string;
    email: string;
};

const ResetPassword = ({ token, email }: ResetPasswordProps) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        token,
        email,
        password: "",
        password_confirmation: "",
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("password.store"), {
            onFinish: () => reset("password", "password_confirmation"),
        });
    };

    return (
        <Box>
            <Head title="Reset Password" />
            <Box maxW="lg" mx="auto" mt={10} p={8} borderWidth={1} rounded="lg" bg="white">
                <Heading size="lg" mb={6} color={"#4D4D4F"}>パスワード再設定</Heading>
                <Text mb={6}>
                    新しいパスワードを入力してください。確認のためもう一度同じパスワードを入力します。
                </Text>

                <form onSubmit={submit}>
                    <VStack spacing={5} align="stretch">
                        {/* メールアドレス */}
                        <FormControl isInvalid={!!errors.email}>
                            <FormLabel>メールアドレス</FormLabel>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                autoComplete="username"
                                onChange={(e) => setData("email", e.target.value)}
                            />
                            <FormErrorMessage>{errors.email}</FormErrorMessage>
                        </FormControl>

                        {/* パスワード */}
                        <FormControl isInvalid={!!errors.password}>
                            <FormLabel>新しいパスワード</FormLabel>
                            <Input
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                autoComplete="new-password"
                                autoFocus
                                onChange={(e) => setData("password", e.target.value)}
                            />
                            <FormErrorMessage>{errors.password}</FormErrorMessage>
                        </FormControl>

                        {/* パスワード確認 */}
                        <FormControl isInvalid={!!errors.password_confirmation}>
                            <FormLabel>パスワード（確認）</FormLabel>
                            <Input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                autoComplete="new-password"
                                onChange={(e) => setData("password_confirmation", e.target.value)}
                            />
                            <FormErrorMessage>{errors.password_confirmation}</FormErrorMessage>
                        </FormControl>

                        {/* トークン（非表示） */}
                        <input type="hidden" name="token" value={data.token} />

                        <Box textAlign="right" pt={2}>
                            <Button
                                type="submit"
                                color="white"
                                bg="green.800"
                                _hover={{ bg: "green.700" }}
                                _disabled={{ bg: "green.300", cursor: "not-allowed" }}
                                isLoading={processing}
                                loadingText="送信中..."
                            >
                                パスワードをリセット
                            </Button>
                        </Box>
                    </VStack>
                </form>
            </Box>
        </Box>
    );
}

ResetPassword.layout = (page: React.ReactNode) => (
    <MainLayout title="パスワードリセット">{page}</MainLayout>
);

export default ResetPassword;
