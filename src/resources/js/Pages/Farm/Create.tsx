import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, FormControl, FormLabel, FormErrorMessage, Input, Select, Textarea, Button, } from "@chakra-ui/react";
import { useForm } from "@inertiajs/react";

type State = {
    id: number;
    name: string;
};

type CreateProps = {
    states: State[];
};

const Create = ({ states }: CreateProps) => {
    // ✅ Laravel連携用
    const { data, setData, post, processing, errors: serverErrors } = useForm({
        name: "",
        phone_number: "",
        email: "",
        street_address: "",
        suburb: "",
        postcode: "",
        state_id: "",
        description: "",
    });

    const [clientErrors, setClientErrors] = React.useState<Record<string, string>>({});

    const displayErrors = { ...serverErrors, ...clientErrors };

    const handleChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>
    ) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        const newClientErrors: Record<string, string> = {};

        if (!data.name) newClientErrors.name = "ファーム名は必須です。";
        if (!data.street_address) newClientErrors.street_address = "住所を入力してください。";
        if (!data.suburb) newClientErrors.suburb = "地域を入力してください。";
        if (!data.postcode) newClientErrors.postcode = "郵便番号を入力してください。";
        if (!data.state_id) newClientErrors.state_id = "州を選択してください。";

        setClientErrors(newClientErrors);

        if (Object.keys(newClientErrors).length > 0) return;

        post(route("farm.store"), {
            onError: (errorBag) => {
                console.error("Laravel validation errors:", errorBag);
            },
            onSuccess: () => {
                setClientErrors({});
            },
        });
    };

    return (
        <Box m={2} w={"90%"}>
            <Heading as={"h4"} mb={4}>
                ファーム新規登録
            </Heading>
            <form onSubmit={handleSubmit}>
                {/* ファーム名 */}
                <FormControl mb={2} isRequired isInvalid={!!displayErrors.name}>
                    <FormLabel htmlFor="name">ファーム名</FormLabel>
                    <Input
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        onChange={handleChange}
                        placeholder="Rugby Farm"
                        maxLength={50}
                    />
                    <FormErrorMessage>{displayErrors.name}</FormErrorMessage>
                </FormControl>

                {/* 電話番号 */}
                <FormControl mb={2} isInvalid={!!displayErrors.phone_number}>
                    <FormLabel htmlFor="phone_number">
                        電話番号
                        <Text as="span" color="gray.500" fontSize="sm">
                            （任意）
                        </Text>
                    </FormLabel>
                    <Input
                        id="phone_number"
                        type="tel"
                        name="phone_number"
                        value={data.phone_number}
                        onChange={handleChange}
                        placeholder="07-5466-3200"
                        inputMode="numeric"
                        maxLength={15}

                    />
                    <FormErrorMessage>{displayErrors.phone_number}</FormErrorMessage>
                </FormControl>

                {/* メール */}
                <FormControl mb={2} isInvalid={!!displayErrors.email}>
                    <FormLabel htmlFor="email">
                        メールアドレス
                        <Text as="span" color="gray.500" fontSize="sm">
                            （任意）
                        </Text>
                    </FormLabel>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        onChange={handleChange}
                        placeholder="test@example.com"
                        maxLength={255}
                    />
                    <FormErrorMessage>{displayErrors.email}</FormErrorMessage>
                </FormControl>

                {/* 住所 */}
                <FormControl mb={2} isRequired isInvalid={!!displayErrors.street_address}>
                    <FormLabel htmlFor="street_address">Street Address</FormLabel>
                    <Input
                        id="street_address"
                        type="text"
                        name="street_address"
                        value={data.street_address}
                        onChange={handleChange}
                        placeholder="22 Hoods Road"
                        maxLength={100}
                    />
                    <FormErrorMessage>{displayErrors.street_address}</FormErrorMessage>
                </FormControl>

                {/* Suburb */}
                <FormControl mb={2} isRequired isInvalid={!!displayErrors.suburb}>
                    <FormLabel htmlFor="suburb">Suburb / Town</FormLabel>
                    <Input
                        id="suburb"
                        type="text"
                        name="suburb"
                        value={data.suburb}
                        onChange={handleChange}
                        placeholder="Gatton"
                        maxLength={50}
                    />
                    <FormErrorMessage>{displayErrors.suburb}</FormErrorMessage>
                </FormControl>

                {/* Postcode */}
                <FormControl mb={2} isRequired isInvalid={!!displayErrors.postcode}>
                    <FormLabel htmlFor="postcode">Postcode</FormLabel>
                    <Input
                        id="postcode"
                        type="text"
                        name="postcode"
                        value={data.postcode}
                        onChange={handleChange}
                        placeholder="4343"
                        inputMode="numeric"
                    />
                    <FormErrorMessage>{displayErrors.postcode}</FormErrorMessage>
                </FormControl>

                {/* State */}
                <FormControl mb={2} isRequired isInvalid={!!displayErrors.state_id}>
                    <FormLabel htmlFor="state_id">State</FormLabel>
                    <Select
                        id="state_id"
                        name="state_id"
                        value={data.state_id}
                        onChange={handleChange}
                        placeholder="select a state"
                    >
                        {states.map((state) => (
                            <option key={state.id} value={state.id}>
                                {state.name}
                            </option>
                        ))}
                    </Select>
                    <FormErrorMessage>{displayErrors.state_id}</FormErrorMessage>
                </FormControl>

                {/* 説明 */}
                <FormControl mb={2} isInvalid={!!displayErrors.description}>
                    <FormLabel htmlFor="description">
                        説明
                        <Text as="span" color="gray.500" fontSize="sm">
                            （任意）
                        </Text>
                    </FormLabel>
                    <Textarea
                        id="description"
                        name="description"
                        value={data.description}
                        onChange={handleChange}
                        placeholder="自由記述欄（なるべく記入をお願いします）"
                    />
                    <FormErrorMessage>{displayErrors.description}</FormErrorMessage>
                </FormControl>

                {/* ボタン */}
                <Button type="submit" colorScheme="green" isLoading={processing}>
                    登録
                </Button>
            </form>
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (
    <MainLayout title="ファーム情報サイト">{page}</MainLayout>
);

export default Create;
