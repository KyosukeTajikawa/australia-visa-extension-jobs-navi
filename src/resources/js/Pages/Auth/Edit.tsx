import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, HStack, FormControl, FormLabel, FormErrorMessage, Input, Button, RadioGroup, Radio } from "@chakra-ui/react";
import { useForm, router } from "@inertiajs/react";

type FormData = {
    _method: string;
    file?: File | null;
    nickname: string;
    email: string;
    gender: number | null;
    birthday: string;
}

type User = {
    file?: File | null;
    nickname: string;
    email: string;
    gender: number | null;
    birthday?: string | null;
    image?: {id: number;} | null;
}

type UserProps = {
    user: User;
}

const Edit = ({ user }: UserProps) => {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        _method: "put",
        file: null,
        nickname: user.nickname,
        email: user.email,
        gender: user.gender,
        birthday: user.birthday ?? "",
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        post(route("update"), {
            preserveScroll: true,
            forceFormData: true,
        });
    };

    return (
        <Box w={{ base: "90%", md: "60%" }} mx={"auto"} mt={"150px"}>

            <Heading as={"h3"} mb={4} fontWeight={"bold"} fontSize={{ base: "18px", md: "24px" }} color={"gray.600"}>編集</Heading>

            <form onSubmit={handleSubmit}>

                {/* 画像 */}
                <FormControl mb={2}>
                    <FormLabel htmlFor="file">名前<Text as="span" color="gray.500" fontSize="sm">（任意）</Text></FormLabel>
                    <Text as="span" color="gray.500" fontSize="sm">※画像を選択しない場合は、前回の画像登録から変更ありません。</Text>
                    <Input
                        id="file"
                        name="file"
                        type="file"
                        accept="image/*"
                        onChange={(e) => {
                            const file = e.target.files?.[0] ?? null;
                            setData('file', file);
                        }}
                        mt={"1"}
                        w={"full"}
                    />
                    <FormErrorMessage>{errors.nickname}</FormErrorMessage>
                </FormControl>

                {/* 名前 */}
                <FormControl mb={2} isRequired isInvalid={!!errors.nickname}>
                    <FormLabel htmlFor="nickname">名前</FormLabel>
                    <Input
                        id="nickname"
                        name="nickname"
                        type="text"
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
                        onChange={(val: string) => setData('gender', val === "" ? null : Number(val))}
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

                <Box mt="4"
                    display={"flex"}
                    alignItems={"center"}
                    justifyContent={"space-between"}
                >
                    {user?.image && (
                        <Button onClick={() => router.delete(route("user.image.destroy", { id: user.id }))}>
                            前回登録の画像削除
                        </Button>
                    )}
                    <Button
                        type="submit"
                        ml="4"
                        bg={"green.800"}
                        color={"white"}
                        _hover={{ bg: "green.700" }}
                        isLoading={processing}
                    >
                        変更
                    </Button>
                </Box>
            </form>
        </Box>
    );
}

Edit.layout = (page: React.ReactNode) => (
    <MainLayout title="プロフィール編集">{page}</MainLayout>
);
export default Edit;
