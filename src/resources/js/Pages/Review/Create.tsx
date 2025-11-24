import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, FormControl, FormLabel, FormErrorMessage, Input, Textarea, Button, Select, HStack, RadioGroup, Radio } from "@chakra-ui/react";
import { StarIcon } from '@chakra-ui/icons';
import { useForm } from "@inertiajs/react";

type Farm = {
    id: number;
    name: string;
}

type ApplicationMethod = {
    id: number;
    name: string;
}

type FormData = {
    work_position: string;
    hourly_wage: string;
    pay_type: number;
    is_car_required: number;
    start_date: string;
    end_date: string;
    application_method_id: string;
    application_method_other: string;
    farm_rating: number;
    comment: string;
};

type CreateProps = {
    farm: Farm;
    applicationMethods: ApplicationMethod[];
}

const Create = ({ farm, applicationMethods }: CreateProps) => {
    const [selectedApplicationMethod, setSelectedApplicationMethod] = useState("");
    const [hoverFarmRating, setHoverFarmRating] = useState(0);
    const { data, setData, post, processing, errors: serverErrors } = useForm<FormData>({
        work_position: "",
        hourly_wage: "",
        pay_type: 1,
        is_car_required: 1,
        start_date: "",
        end_date: "",
        application_method_id: "",
        application_method_other: "",
        farm_rating: 1,
        comment: "",
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("review.store", { 'id': farm.id }), {
            preserveScroll: true,
        });
    }


    return (
        <Box my={2} w={{ base: "80%", xl: "1280px" }} mx={"auto"}>
            <Heading as={"h1"} color={"#4D4D4F"} my={3}>{farm.name}のレビュー登録</Heading>
            <form onSubmit={handleSubmit}>
                {/* 仕事のポジション */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.work_position}>
                    <FormLabel htmlFor="work_position">仕事のポジション</FormLabel>
                    <Input id="work_position" type="text" name="work_position" autoComplete="work_position" value={data.work_position} placeholder="ピッキング・パッキング..." maxLength={50}
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.work_position}</FormErrorMessage>
                </FormControl>

                {/* 時給 */}
                <FormControl mb={2} isInvalid={!!serverErrors.hourly_wage}>
                    <FormLabel htmlFor="hourly_wage" >時給<Text as="span" color="gray.500" fontSize="sm" pl={2}>*時給の方のみご入力ください。</Text></FormLabel>
                    <Input id="hourly_wage" type="text" autoComplete="text" name="hourly_wage" value={data.hourly_wage} placeholder="30.7" inputMode="decimal"
                        onChange={handleChange}
                        isDisabled={data.pay_type === 2}
                        opacity={data.pay_type === 2 ? 0.5 : 1}
                        cursor={data.pay_type === 2 ? "not-allowed" : "text"} />
                    <FormErrorMessage>{serverErrors.hourly_wage}</FormErrorMessage>
                </FormControl>

                {/* 支払種別 */}
                <FormControl as="fieldset" mb={2} isRequired isInvalid={!!serverErrors.pay_type}>
                    <FormLabel as="legend" id="pay_type_label">支払種別</FormLabel>
                    <RadioGroup value={String(data.pay_type)} aria-labelledby="pay_type_label"
                        onChange={(val: string) => setData("pay_type", Number(val))}
                    >
                        <HStack spacing={6}>
                            <Radio value="1">時給</Radio>
                            <Radio value="2">歩合</Radio>
                        </HStack>
                    </RadioGroup>
                    <FormErrorMessage>{serverErrors.pay_type}</FormErrorMessage>
                </FormControl>

                {/* 車の有無 */}
                <FormControl as="fieldset" mb={2} isRequired isInvalid={!!serverErrors.is_car_required}>
                    <FormLabel as="legend" id="is_car_required_label">車の有無</FormLabel>
                    <RadioGroup aria-labelledby="is_car_required_label" value={String(data.is_car_required)}
                        onChange={(val: string) => setData("is_car_required", Number(val))}
                    >
                        <HStack spacing={6}>
                            <Radio value="1">必要</Radio>
                            <Radio value="2">不要</Radio>
                        </HStack>
                    </RadioGroup>
                    <FormErrorMessage>{serverErrors.is_car_required}</FormErrorMessage>
                </FormControl>

                {/* 開始日 */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.start_date}>
                    <FormLabel htmlFor="start_date">開始日</FormLabel>
                    <Input id="start_date" type="date" name="start_date" value={data.start_date} placeholder="yyyy-mm-dd" inputMode="numeric"
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.start_date}</FormErrorMessage>
                </FormControl>

                {/* 終了日 */}
                <FormControl mb={2} isInvalid={!!serverErrors.end_date}>
                    <FormLabel htmlFor="end_date">終了日</FormLabel>
                    <Input id="end_date" type="date" name="end_date" value={data.end_date} placeholder="yyyy-mm-dd" inputMode="numeric"
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.end_date}</FormErrorMessage>
                </FormControl>

                {/* 応募方法 */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.application_method_id}>
                    <FormLabel htmlFor="application_method_id">応募方法</FormLabel>
                    <Select
                        id="application_method_id" name="application_method_id" value={data.application_method_id}
                        onChange={(e) => {
                            handleChange(e);
                            setSelectedApplicationMethod(e.target.value);
                            if (e.target.value !== "99") {
                                setData("application_method_other", "");
                            }
                        }}
                        placeholder="応募方法を選択"
                    >
                        {applicationMethods.map((applicationMethod) => (
                            <option key={applicationMethod.id} value={applicationMethod.id}>{applicationMethod.name}</option>
                        ))}
                    </Select>
                    <FormErrorMessage>{serverErrors.application_method_id}</FormErrorMessage>
                </FormControl>

                {/* その他の応募方法 */}
                <FormControl mb={2} isInvalid={!!serverErrors.application_method_other}>
                    <FormLabel htmlFor="application_method_other">その他の応募方法<Text as="span" color="gray.500" fontSize="sm">（その他を選択場合は、必須項目となります。）</Text></FormLabel>
                    <Input id="application_method_other" type="text" name="application_method_other" autoComplete="application_method_other" value={data.application_method_other}
                        isDisabled={selectedApplicationMethod !== "99"}
                        opacity={selectedApplicationMethod !== "99" ? 0.5 : 1}
                        cursor={selectedApplicationMethod !== "99" ? "not-allowed" : "text"}
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.application_method_other}</FormErrorMessage>
                </FormControl>

                {/* 評価 */}
                <Text>評価</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.farm_rating || i < hoverFarmRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('farm_rating', i + 1)} onMouseEnter={() => setHoverFarmRating(i + 1)}
                            onMouseLeave={() => setHoverFarmRating(0)} />
                    )
                    )}
                </HStack>

                {/* コメント */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.comment}>
                    <FormLabel htmlFor="comment">コメント</FormLabel>
                    <Textarea id="comment" name="comment" value={data.comment} placeholder="自由記述欄（なるべく記入をお願いします）" maxLength={1000} inputMode="numeric"
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.comment}</FormErrorMessage>
                </FormControl>

                {/* ボタン */}
                <Button type="submit" bg={"green.800"} _hover={{ bg: "green.700" }} color={"white"} isLoading={processing}>投稿</Button>
            </form>
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (
    <MainLayout title="レビュー登録">{page}</MainLayout>
);
export default Create;
