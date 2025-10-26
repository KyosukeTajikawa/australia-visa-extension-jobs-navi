import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, HStack, FormControl, FormLabel, FormErrorMessage, Input, Button, RadioGroup, Radio } from "@chakra-ui/react";
import { useForm, Link } from "@inertiajs/react";

type FormData = {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    gender: number | null;
    birthday: string;
};

const Register = () => {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        gender: null,
        birthday: '',
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <Box w={{ base: "90%", md: "60%" }} mx={"auto"} mt={"150px"}>

            <Heading as={"h3"} mb={4} fontWeight={"bold"} fontSize={{ base: "18px", md: "24px" }} color={"gray.600"}>新規登録</Heading>

            <form onSubmit={handleSubmit}>
                {/* 名前 */}
                <FormControl mb={2} isRequired isInvalid={!!errors.name}>
                    <FormLabel htmlFor="name">名前</FormLabel>
                    <Input
                        id="name"
                        name="name"
                        value={data.name}
                        autoComplete="name"
                        onChange={handleChange}
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.name}</FormErrorMessage>
                </FormControl>
                {/* メールアドレス */}
                <FormControl mb={2} isRequired isInvalid={!!errors.email}>
                    <FormLabel htmlFor="email">メールアドレス</FormLabel>
                    <Input
                        id="email"
                        name="email"
                        value={data.email}
                        autoComplete="email"
                        onChange={handleChange}
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.email}</FormErrorMessage>
                </FormControl>
                {/* 性別 */}
                <FormControl as="fieldset" mb={2} isRequired isInvalid={!!errors.gender}>
                    <FormLabel as="legend" id="gender">性別</FormLabel>
                    <RadioGroup aria-labelledby="gender"
                        value={String(data.gender ?? "")}
                        onChange={(val:string) => setData('gender', val === "" ? null : Number(val))}
                    >
                        <HStack spacing={6}>
                            <Radio value="1">男性</Radio>
                            <Radio value="2">女性</Radio>
                        </HStack>
                    </RadioGroup>
                    <FormErrorMessage>{errors.gender}</FormErrorMessage>
                </FormControl>
                {/* 生年月日 */}
                <FormControl mb={2} isInvalid={!!errors.birthday}>
                    <FormLabel htmlFor="birthday">生年月日<Text as="span" color="gray.500" fontSize="sm">（任意）</Text></FormLabel>
                    <Input
                        id="birthday"
                        name="birthday"
                        value={data.birthday}
                        autoComplete="birthday"
                        onChange={handleChange}
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.birthday}</FormErrorMessage>
                </FormControl>
                {/* パスワード */}
                <FormControl mb={2} isRequired isInvalid={!!errors.password}>
                    <FormLabel htmlFor="password">パスワード</FormLabel>
                    <Input
                        id="password"
                        name="password"
                        value={data.password}
                        autoComplete="password"
                        onChange={handleChange}
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.password}</FormErrorMessage>
                </FormControl>
                {/* パスワード確認 */}
                <FormControl mb={2} isRequired isInvalid={!!errors.password_confirmation}>
                    <FormLabel htmlFor="password_confirmation">パスワード確認</FormLabel>
                    <Input
                        id="password_confirmation"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        autoComplete="password_confirmation"
                        onChange={handleChange}
                        c mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.password_confirmation}</FormErrorMessage>
                </FormControl>

                <Box mt="4"
                    display={"flex"}
                    alignItems={"center"}
                    justifyContent={"flex-end"}>
                    <Link
                        href={route('login')}
                        size="sm"
                        color="gray.600"
                        textDecoration="underline"
                        borderRadius="md"
                        _hover={{
                            color: "gray.900",
                        }}
                        _focus={{
                            outline: "none",
                            ring: 2,
                            ringColor: "indigo.500",
                            ringOffset: 2,
                        }}
                    >
                        Already registered?
                    </Link>

                    <Button type="submit" ml="4" colorScheme={"green"} isLoading={processing}>
                        Register
                    </Button>
                </Box>
            </form>
        </Box>
    );
}

Register.layout = (page: React.ReactNode) => (
    <MainLayout title="新規登録">{page}</MainLayout>
);
export default Register;
