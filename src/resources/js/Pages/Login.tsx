import React from "react";
import axios from 'axios';
import { Box, Heading, FormControl, FormLabel, FormErrorMessage, Input, Button } from "@chakra-ui/react";
import { LockIcon } from '@chakra-ui/icons';
import { useForm, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";

    const Login = () => {
        const { data, setData, post, processing, errors } = useForm({
            email: "",
            password: "",
        });

        const handleSubmit = async (e: React.FormEvent) => {
            e.preventDefault();

            // SanctumのCSRF初期化（必要なら最初の1回）
            await axios.get("/sanctum/csrf-cookie");

            post("/login", {
                onSuccess: () => router.visit("/home"),
                preserveScroll: true,
            });
        };


    return (
        <Box
            w={{ base: "90%", md: "60%" }}
            mx={"auto"}
            mt={"150px"}
        >
            <Heading
                as={"h3"}
                mb={4}
                fontWeight={"bold"}
                fontSize={{ base: "18px", md: "24px" }}
                color={"gray.600"}
            ><LockIcon />
                ログイン
            </Heading>
            <form
                onSubmit={handleSubmit}
            >
                <FormControl
                    mb={2}
                    isRequired
                    isInvalid={!!errors.email}
                >
                    <FormLabel
                        htmlFor="email"
                    >
                        メールアドレス
                    </FormLabel>
                    <Input
                        id="email"
                        name="email"
                        type="email"
                        autoComplete="email"
                        placeholder="test@example.com"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                    />
                    <FormErrorMessage>
                        {errors.email}
                    </FormErrorMessage>
                </FormControl>
                <FormControl
                    mb={4}
                    isRequired
                    isInvalid={!!errors.password}
                >
                    <FormLabel
                        htmlFor="password"
                    >
                        パスワード
                    </FormLabel>
                    <Input
                        id="password"
                        name="password"
                        placeholder="パスワード"
                        type="password"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                    />
                    <FormErrorMessage>
                        {errors.password}
                    </FormErrorMessage>
                </FormControl>
                <Button
                    type="submit"
                    bg={"green.800"}
                    color={"white"}
                    _hover={{ bg: "green.700" }}
                    isLoading={processing}
                >
                    ログイン
                </Button>
            </form>
        </Box>
    )
}

Login.layout = (page: React.ReactNode) => <MainLayout children={page} title="ファーム情報サイト" />
export default Login;
