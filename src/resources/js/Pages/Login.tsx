import React from "react";
import { Box, Heading, FormControl, FormLabel, Input, Button } from "@chakra-ui/react";
import { LockIcon } from '@chakra-ui/icons';
import { useForm, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";

const Login = () => {

    const { data, setData, post, processing, errors} = useForm({
        email: "",
        password: "",
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("login"));
    }


    return (
        <Box w={{base:"90%", md:"60%"}} mx={"auto"} mt={"150px"}>
            <Heading as={"h3"} mb={4} fontWeight={"bold"} fontSize={{ base: "18px", md: "24px" }} color={"gray.600"}><LockIcon />ログイン</Heading>
            <form onSubmit={handleSubmit}>
                <FormControl mb={2} isRequired isInvalid={!!errors.email}>
                <FormLabel htmlFor="email">メールアドレス</FormLabel>
                    <Input id="email" name="email" type="email" placeholder="例)test@example.com"  value={data.email} onChange={(e) => setData("email", e.target.value)}/>
            </FormControl>
                <FormControl mb={4} isRequired isInvalid={!!errors.email}>
                <FormLabel htmlFor="password">パスワード</FormLabel>
                    <Input id="password" name="password" placeholder="●●●●●●" type="password" value={data.password} onChange={(e) => setData("password", e.target.value)}/>
            </FormControl>
            <Button type="submit" colorScheme={"green"} isLoading={processing}>ログイン</Button>
            </form>
        </Box>
    )
}

Login.layout = (page: React.ReactNode) => <MainLayout children={page} title="ファーム情報サイト" />
export default Login;
