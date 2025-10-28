import React from "react";
import axios from 'axios';
import { Box, Heading, FormControl, FormLabel, FormErrorMessage, Input, Button } from "@chakra-ui/react";
import { LockIcon } from '@chakra-ui/icons';
import { useForm, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";

const Login = () => {

    const { data, setData, processing, errors } = useForm({
        email: "",
        password: "",
    });

    async function handleLogin(email: string, password: string) {
        // 1. CSRF初期化
        await axios.get('/sanctum/csrf-cookie');

        // 2. ログイン
        await axios.post('/login', { email, password });

        router.visit("/home");
    }

    const handleSubmit = (ev: React.FormEvent) => {
        ev.preventDefault();
        handleLogin(data.email, data.password);
    }


    return (
        <Box w={{ base: "90%", md: "60%" }} mx={"auto"} mt={"150px"}>
            <Heading as={"h3"} mb={4} fontWeight={"bold"} fontSize={{ base: "18px", md: "24px" }} color={"gray.600"}><LockIcon />ログイン</Heading>
            <form onSubmit={handleSubmit}>
                <FormControl mb={2} isRequired isInvalid={!!errors.email}>
                    <FormLabel htmlFor="email">メールアドレス</FormLabel>
                    <Input id="email" name="email" type="email" placeholder="例)test@example.com" value={data.email} onChange={(e) => setData("email", e.target.value)} />
                    <FormErrorMessage>{errors.email}</FormErrorMessage>
                </FormControl>
                <FormControl mb={4} isRequired isInvalid={!!errors.password}>
                    <FormLabel htmlFor="password">パスワード</FormLabel>
                    <Input id="password" name="password" placeholder="●●●●●●" type="password" value={data.password} onChange={(e) => setData("password", e.target.value)} />
                    <FormErrorMessage>{errors.email}</FormErrorMessage>
                </FormControl>
                <Button type="submit" colorScheme={"green"} isLoading={processing}>ログイン</Button>
            </form>
        </Box>
    )
}

Login.layout = (page: React.ReactNode) => <MainLayout children={page} title="ファーム情報サイト" />
export default Login;
