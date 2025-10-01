import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, HStack, Image, Text, FormControl, FormLabel, FormErrorMessage, Input, Select, Textarea, Button } from "@chakra-ui/react";
import { useForm, router } from "@inertiajs/react";

type State = {
    id: number;
    name: string;
}

type CreateProps = {
    states: State[];
};

const Create = ({ states }: CreateProps) => {
    const {data, setData, processing, errors} = useForm({
        name: "",
        phone_number: "",
        email: "",
        street_address: "",
        suburb: "",
        postcode: "",
        state_id: "",
        description: "",
    })

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => {
        const {name, value} = e.target;
        setData({
            ...data,
            [name]:value,
        })
        console.log(data);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        router.post(route("farm.store"), data);
    }
    return (
        <Box m={2} w={"90%"}>
            <Heading as={"h4"}>ファーム新規登録</Heading>
            <form onSubmit={handleSubmit}>
                <FormControl mb={2} isRequired isInvalid={!!errors.name}>
                    <FormLabel htmlFor="name">ファーム名</FormLabel>
                    <Input id="name" type="text" name="name" value={data.name} onChange={handleChange}/>
                    <FormErrorMessage>{errors.name}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isInvalid={!!errors.phone_number}>
                    <FormLabel htmlFor="phone_number">電話番号<Text as="span" color="gray.500" fontSize="sm">(任意)</Text></FormLabel>
                    <Input id="phone_number" type="tel" name="phone_number" value={data.phone_number} onChange={handleChange}/>
                    <FormErrorMessage>{errors.phone_number}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isInvalid={!!errors.email}>
                    <FormLabel htmlFor="email">メールアドレス<Text as="span" color="gray.500" fontSize="sm">(任意)</Text></FormLabel>
                    <Input id="email" type="email" name="email" value={data.email} onChange={handleChange}/>
                    <FormErrorMessage>{errors.email}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isRequired isInvalid={!!errors.street_address}>
                    <FormLabel htmlFor="street_address">Street Address</FormLabel>
                    <Input id="street_address" type="text" name="street_address" value={data.street_address} onChange={handleChange}/>
                    <FormErrorMessage>{errors.street_address}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isRequired isInvalid={!!errors.suburb}>
                    <FormLabel htmlFor="suburb">Suburb / Town</FormLabel>
                    <Input id="suburb" type="text" name="suburb" value={data.suburb} onChange={handleChange}/>
                    <FormErrorMessage>{errors.suburb}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isRequired isInvalid={!!errors.postcode}>
                    <FormLabel htmlFor="postcode">Postcode</FormLabel>
                    <Input id="postcode" type="text" name="postcode" value={data.postcode} onChange={handleChange}/>
                    <FormErrorMessage>{errors.postcode}</FormErrorMessage>
            </FormControl>
                <FormControl mb={2} isRequired isInvalid={!!errors.state_id}>
                    <FormLabel htmlFor="state_id">State</FormLabel>
                <Select id="state_id" name="state_id" value={data.state_id} onChange={handleChange} placeholder="select a state">
                    {states.map((state) => (
                        <option key={state.id} value={state.id}>{state.name}</option>
                    ))}
                    </Select>
                    <FormErrorMessage>{errors.state_id}</FormErrorMessage>
            </FormControl>
            <FormControl mb={2} isRequired isInvalid={!!errors.postcode}>
                <FormLabel htmlFor="description">説明</FormLabel>
                    <Textarea id="description" name="description" value={data.description} onChange={handleChange} >
                        </Textarea>
                <FormErrorMessage>{errors.description}</FormErrorMessage>
            </FormControl>
                <Button type="submit" colorScheme={"green"} isLoading={processing}>登録</Button>
            </form>
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Create;
