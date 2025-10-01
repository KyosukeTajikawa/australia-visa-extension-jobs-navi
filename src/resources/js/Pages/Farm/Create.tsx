import React, {useState} from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, FormControl, FormLabel, FormErrorMessage, Input, Select, Textarea, Button, HStack } from "@chakra-ui/react";
import { useForm } from "@inertiajs/react";

type FormData = {
    name: string;
    phone_number: string;
    email: string;
    street_address: string;
    suburb: string;
    postcode: string;
    state_id: string;
    description: string;
    files: File[];
}

type State = {
    id: number;
    name: string;
};

type CreateProps = { states: State[] };

const Create = ({ states }: CreateProps) => {
    const { data, setData, post, processing, errors: serverErrors, reset } = useForm<FormData>({
        name: "",
        phone_number: "",
        email: "",
        street_address: "",
        suburb: "",
        postcode: "",
        state_id: "",
        description: "",
        files: [],
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const images = e.target.files ? Array.from(e.target.files) : [];
        const newFiles = [...data.files, ...images];

        if (newFiles.length > 3) {
            const initialize = newFiles.slice(0,0);
            setData("files", initialize);
            e.target.value = "";

            alert("画像は3枚以下にしてください。");
            return;
        }

        setData("files", newFiles);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("farm.store"), {
            preserveScroll: true,
            onSuccess: () => reset("files"),
        });
    };

    return (
        <Box m={2} w={"90%"}>
            <Heading as={"h4"} mb={4}>ファーム新規登録</Heading>
            <form onSubmit={handleSubmit} encType="multipart/form-data">
                {/* ファーム名 */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.name}>
                    <FormLabel htmlFor="name">ファーム名</FormLabel>
                    <Input
                        id="name" type="text" name="name" value={data.name}
                        onChange={handleChange} placeholder="Rugby Farm" maxLength={50}
                    />
                    <FormErrorMessage>{serverErrors.name}</FormErrorMessage>
                </FormControl>

                {/* 電話番号 */}
                <FormControl mb={2} isInvalid={!!serverErrors.phone_number}>
                    <FormLabel htmlFor="phone_number">
                        電話番号 <Text as="span" color="gray.500" fontSize="sm">（任意）</Text>
                    </FormLabel>
                    <Input
                        id="phone_number" type="tel" name="phone_number" value={data.phone_number}
                        onChange={handleChange} placeholder="0754663200" inputMode="numeric" pattern="^\d{10,11}$" title="電話番号はハイフンなしの数字10桁または11桁で入力してください。"
                    />
                    <FormErrorMessage>{serverErrors.phone_number}</FormErrorMessage>
                </FormControl>

                {/* メール */}
                <FormControl mb={2} isInvalid={!!serverErrors.email}>
                    <FormLabel htmlFor="email">
                        メールアドレス <Text as="span" color="gray.500" fontSize="sm">（任意）</Text>
                    </FormLabel>
                    <Input
                        id="email" type="email" name="email" value={data.email}
                        onChange={handleChange} placeholder="test@example.com" maxLength={255}
                    />
                    <FormErrorMessage>{serverErrors.email}</FormErrorMessage>
                </FormControl>

                {/* 住所 */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.street_address}>
                    <FormLabel htmlFor="street_address">Street Address</FormLabel>
                    <Input
                        id="street_address" type="text" name="street_address" value={data.street_address}
                        onChange={handleChange} placeholder="22 Hoods Road" maxLength={100}
                    />
                    <FormErrorMessage>{serverErrors.street_address}</FormErrorMessage>
                </FormControl>

                {/* Suburb */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.suburb}>
                    <FormLabel htmlFor="suburb">Suburb / Town</FormLabel>
                    <Input
                        id="suburb" type="text" name="suburb" value={data.suburb}
                        onChange={handleChange} placeholder="Gatton" maxLength={50}
                    />
                    <FormErrorMessage>{serverErrors.suburb}</FormErrorMessage>
                </FormControl>

                {/* Postcode */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.postcode}>
                    <FormLabel htmlFor="postcode">Postcode</FormLabel>
                    <Input
                        id="postcode" type="text" name="postcode" value={data.postcode}
                        onChange={handleChange} placeholder="4343" inputMode="numeric" maxLength={4}
                    />
                    <FormErrorMessage>{serverErrors.postcode}</FormErrorMessage>
                </FormControl>

                {/* State */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.state_id}>
                    <FormLabel htmlFor="state_id">State</FormLabel>
                    <Select
                        id="state_id" name="state_id" value={data.state_id}
                        onChange={handleChange} placeholder="select a state"
                    >
                        {states.map((state) => (
                            <option key={state.id} value={state.id}>{state.name}</option>
                        ))}
                    </Select>
                    <FormErrorMessage>{serverErrors.state_id}</FormErrorMessage>
                </FormControl>

                {/* 説明 */}
                <FormControl mb={2} isInvalid={!!serverErrors.description}>
                    <FormLabel htmlFor="description">
                        説明 <Text as="span" color="gray.500" fontSize="sm">（任意）</Text>
                    </FormLabel>
                    <Textarea
                        id="description" name="description" value={data.description}
                        onChange={handleChange} placeholder="自由記述欄（なるべく記入をお願いします）" maxLength={1000}
                    />
                    <FormErrorMessage>{serverErrors.description}</FormErrorMessage>
                </FormControl>

                {/* 画像 */}
                <FormControl mb={2} isInvalid={!!serverErrors.files}>
                    <FormLabel htmlFor="files">ファーム画像（最大5MB目安）<Text as="span" color="gray.500" fontSize="sm">（任意）</Text></FormLabel>
                    {/* プレビュー */}
                    <HStack mb={2}>
                        {
                            data.files.map((file) => (
                                <Box key={file.name} px={2} >
                                    <img src={URL.createObjectURL(file)} alt={file.name} style={{ "width": 100, "height": 100, objectFit: "contain" }} />
                                </Box>
                            ))
                        }
                    </HStack>
                    <Input type="file" name="files[]" id="files" accept="image/*" multiple onChange={handleFileChange} />
                    <FormErrorMessage>{serverErrors.files}</FormErrorMessage>
                </FormControl>

                {/* ボタン */}
                <Button type="submit" colorScheme="green" isLoading={processing}>登録</Button>
            </form>
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (
    <MainLayout title="ファーム情報サイト">{page}</MainLayout>
);
export default Create;
