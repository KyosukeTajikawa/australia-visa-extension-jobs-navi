import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, FormControl, FormLabel, FormErrorMessage, Input, Textarea, Button, HStack, RadioGroup, Radio } from "@chakra-ui/react";
import { StarIcon } from '@chakra-ui/icons';
import { useForm } from "@inertiajs/react";

type Farm = {
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
    work_rating: number;
    salary_rating: number;
    hour_rating: number;
    relation_rating: number;
    overall_rating: number;
    comment: string;
};

type CreateProps = {
    farm: Farm;
}

const Create = ({ farm }: CreateProps) => {
    const [hoverWorkRating, setHoverWorkRating] = useState(0);
    const [hoverSalaryRating, setHoverSalaryRating] = useState(0);
    const [hoverHourRating, setHoverHourRating] = useState(0);
    const [hoverRelationRating, setHoverRelationRating] = useState(0);
    const [hoverOverallRating, setHoverOverallRating] = useState(0);
    const { data, setData, post, processing, errors: serverErrors } = useForm<FormData>({
        work_position: "",
        hourly_wage: "",
        pay_type: 1,
        is_car_required: 1,
        start_date: "",
        end_date: "",
        work_rating: 1,
        salary_rating: 1,
        hour_rating: 1,
        relation_rating: 1,
        overall_rating: 1,
        comment: "",
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setData(name as keyof typeof data, value);
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("review.store", {'id': farm.id}), {
            preserveScroll: true,
        });
    }


    return (
        <Box m={2} w={"90%"}>
            <Heading as={"h1"}>{farm.name}のレビュー登録</Heading>
            <form onSubmit={handleSubmit}>
                {/* 仕事のポジション */}
                <FormControl mb={2} isRequired isInvalid={!!serverErrors.work_position}>
                    <FormLabel htmlFor="work_position">仕事のポジション</FormLabel>
                    <Input id="work_position" type="text" name="work_position" value={data.work_position} placeholder="ピッキング・パッキング..." maxLength={50}
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.work_position}</FormErrorMessage>
                </FormControl>

                {/* 時給 */}
                <FormControl mb={2} isInvalid={!!serverErrors.hourly_wage}>
                    <FormLabel htmlFor="hourly_wage">時給</FormLabel>
                    <Input id="hourly_wage" type="text" name="hourly_wage" value={data.hourly_wage} placeholder="30.7" inputMode="decimal"
                        onChange={handleChange} />
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
                    <Input id="start_date" type="text" name="start_date" value={data.start_date} placeholder="yyyy-mm-dd" inputMode="numeric"
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.start_date}</FormErrorMessage>
                </FormControl>

                {/* 終了日 */}
                <FormControl mb={2} isInvalid={!!serverErrors.end_date}>
                    <FormLabel htmlFor="end_date">終了日</FormLabel>
                    <Input id="end_date" type="text" name="end_date" value={data.end_date} placeholder="yyyy-mm-dd" inputMode="numeric"
                        onChange={handleChange} />
                    <FormErrorMessage>{serverErrors.end_date}</FormErrorMessage>
                </FormControl>

                {/* 仕事内容 */}
                <Text>仕事内容</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.work_rating || i < hoverWorkRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('work_rating', i + 1 )} onMouseEnter={() => setHoverWorkRating(i + 1)}
                            onMouseLeave={() => setHoverWorkRating(0)} />
                    )
                    )}
                </HStack>

                {/* 給料 */}
                <Text>給料</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.salary_rating || i < hoverSalaryRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('salary_rating', i + 1)} onMouseEnter={() => setHoverSalaryRating(i + 1)}
                            onMouseLeave={() => setHoverSalaryRating(0)} />
                    )
                    )}
                </HStack>

                {/* 労働時間 */}
                <Text>労働時間</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.hour_rating || i < hoverHourRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('hour_rating', i + 1)} onMouseEnter={() => setHoverHourRating(i + 1)}
                            onMouseLeave={() => setHoverHourRating(0)} />
                    )
                    )}
                </HStack>

                {/* 人間関係 */}
                <Text>人間関係</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.relation_rating || i < hoverRelationRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('relation_rating', i + 1)} onMouseEnter={() => setHoverRelationRating(i + 1)}
                            onMouseLeave={() => setHoverRelationRating(0)} />
                    )
                    )}
                </HStack>

                {/* 総合評価 */}
                <Text>総合評価</Text>
                <HStack spacing={1} mb={4}>
                    {Array(5).fill("").map((_, i) =>
                    (
                        <StarIcon key={i} color={i < data.overall_rating || i < hoverOverallRating ? "yellow.500" : "gray.300"} cursor={"pointer"} onClick={() => setData('overall_rating', i + 1)} onMouseEnter={() => setHoverOverallRating(i + 1)}
                            onMouseLeave={() => setHoverOverallRating(0)} />
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
                <Button type="submit" colorScheme="green" isLoading={processing}>投稿</Button>
            </form>
        </Box>
    );
};

Create.layout = (page: React.ReactNode) => (
    <MainLayout title="レビュー登録">{page}</MainLayout>
);
export default Create;
