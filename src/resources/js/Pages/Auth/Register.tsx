import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, HStack, FormControl, FormLabel, FormErrorMessage, Input, Button, RadioGroup, Radio } from "@chakra-ui/react";
import { useForm, Link } from "@inertiajs/react";

type FormData = {
    nickname: string;
    email: string;
    password: string;
    password_confirmation: string;
    gender: number | null;
    birthday: string;
};

const Register = () => {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        nickname: '',
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
                <FormControl mb={2} isRequired isInvalid={!!errors.nickname}>
                    <FormLabel htmlFor="nickname">名前</FormLabel>
                    <Input
                        id="nickname"
                        name="nickname"
                        value={data.nickname}
                        autoComplete="nickname"
                        onChange={handleChange}
                        placeholder="太郎"
                        maxLength={50}
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.nickname}</FormErrorMessage>
                </FormControl>
                {/* メールアドレス */}
                <FormControl mb={2} isRequired isInvalid={!!errors.email}>
                    <FormLabel htmlFor="email">メールアドレス</FormLabel>
                    <Input
                        id="email"
                        name="email"
                        type="email"
                        value={data.email}
                        autoComplete="email"
                        onChange={handleChange}
                        placeholder="test@example.com"
                        maxLength={255}
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
                        type="date"
                        value={data.birthday}
                        autoComplete="birthday"
                        onChange={handleChange}
                        inputMode="numeric"
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
                        type="password"
                        value={data.password}
                        autoComplete="new-password"
                        onChange={handleChange}
                        placeholder="●●●●●●"
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
                        type="password"
                        value={data.password_confirmation}
                        autoComplete="new-password"
                        onChange={handleChange}
                        placeholder="●●●●●●"
                        mt={"1"}
                        display={"block"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.password_confirmation}</FormErrorMessage>
                </FormControl>

                <Box mt="4"
                    display={"flex"}
                    alignItems={"center"}
                    justifyContent={"flex-end"}
                    >

                    <Text
                        as={Link}
                        href={route('login')}
                        size={"sm"}
                        color={"gray.700"}
                        borderRadius={"md"}
                        _hover={{
                            color: "gray.900",
                        }}
                    >
                        Already registered?
                    </Text>

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
