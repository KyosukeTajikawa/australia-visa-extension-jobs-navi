import React from "react";
import { Box, FormControl, FormLabel, Input } from "@chakra-ui/react";
import { LockIcon } from '@chakra-ui/icons';
import { useForm, router } from "@inertiajs/react";


const Login = () => {

    const {data, setData, post, errors} = useForm({
        email: "",
        password: "",
    });

    const handleSubmit(e) => {
        e.preventDefault();
        router.post(route("login"));
    }


    return (
        <Box m={2}>
            <Box mb={2}><LockIcon />ログイン</Box>
            <form onSubmit={handleSubmit}></form>
            <FormControl id="email">
                <FormLabel>メールアドレス</FormLabel>
                <Input isRequired id="email" name="email" type="text" value={data.email} onChange={(e) => setData("email", e.target.value)}></Input>
            </FormControl>
            <FormControl id="password">
                <FormLabel>パスワード</FormLabel>
                <Input isRequired id="password" name="password" type="text" value={data.password} onChange={(e) => setData("password", e.target.value)}></Input>
            </FormControl>
        </Box>
    )
}

export default Login;
