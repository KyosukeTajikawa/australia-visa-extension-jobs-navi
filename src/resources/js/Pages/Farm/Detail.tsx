import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, HStack, Image, Text, Button, Flex } from "@chakra-ui/react";
import { StarIcon, EditIcon } from '@chakra-ui/icons';
import { router } from "@inertiajs/react";
import ReviewList from "@/Components/Organisms/ReviewList";

type State = {
    id: number;
    name: string;
};

type FarmImages = {
    id: number;
    farm_id: number;
    url: string;
};

type Crops = {
    id: number;
    name: string;
}

type Review = {
    id: number;
    start_date: string;
    end_date: string;
    work_position: string;
    pay_type: number;
    hourly_wage: number;
    is_car_required: number;
    work_rating: number;
    salary_rating: number;
    hour_rating: number;
    relation_rating: number;
    overall_rating: number;
    comment: string;
};

type Farm = {
    id: number;
    name: string;
    phone_number?: string;
    email?: string;
    description: string;
    street_address: string;
    suburb: string;
    postcode: string;
    state: State;
    reviews?: Review[];
    images?: FarmImages[];
    crops: Crops[];
};

type DetailProps = { farm: Farm };

const Detail = ({ farm }: DetailProps) => {
    return (
        <Box
            bg={"#FAF7F0"}
            color={"green.800"}
            px={4}
        >
            {/* ファーム */}
            <Box
                w={{ base: "72%", md: "78%", xl: "1220px" }}
                mx={"auto"}
            >
                <Heading
                    as={"h1"}
                    letterSpacing={4}
                    fontSize={{ base: "28px", md: "50px" }}
                    py={3}
                    px={4}
                >
                    {farm.name}
                </Heading>
            </Box>
            <Flex
                wrap={"wrap"}
                w={{ base: "80%", xl: "1280px" }}
                mx={"auto"}
            >
                {farm.images?.map((image) => (
                    <Box
                        key={image.id}
                        p={4}
                        w={{ base: "90%", md: "48%", xl: "45%" }}
                        mx={"auto"}
                    >
                        <Image
                            src={image?.url ?? "https://placehold.co/300x300"}
                            alt={farm.name}
                            w={{ base: "full" }}
                            h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
                            objectFit={"cover"}
                            onError={(e) => {
                                (e.currentTarget as HTMLImageElement).src = "https://placehold.co/300x300";
                            }}
                        />
                    </Box>
                ))}
            </Flex>
            <Box
                w={{ base: "72%", md: "78%", xl: "1220px" }}
                mx={"auto"}
                px={4}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Box
                    display={"flex"}
                    alignItems={"center"}
                >
                    取扱作物：
                    {farm.crops.map((crop) => (
                        <Box
                            key={crop.id}
                            px={2}
                            py={1}
                        >
                            <Text>
                                {crop.name}
                            </Text>
                        </Box>
                    ))}
                </Box>
                <Text
                    mb={1}
                >
                    電話番号：{farm.phone_number ? farm.phone_number : "登録なし"}
                </Text>
                <Text
                    mb={1}
                >
                    メールアドレス：{farm.email ? farm.email : "登録なし"}
                </Text>
                <HStack
                    mb={1}
                >
                    <Text
                    >
                        住所：{farm.street_address}
                    </Text>
                    <Text>
                        {farm.suburb}
                    </Text>
                    <Text>
                        {farm.state.name}
                    </Text>
                    <Text>
                        {farm.postcode}
                    </Text>
                </HStack>
                <Text
                    mb={1}
                >
                    説明
                </Text>
                <Text>{farm.description}</Text>
            </Box>
            {/* レビュー */}
            <Box
                w={{ base: "72%", md: "78%", xl: "1220px" }}
                mx={"auto"}
                px={4}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Heading
                    as={"h1"}
                    fontSize={{ base: "28px", md: "50px" }}
                    py={3}
                >
                    レビュー
                </Heading>
            </Box>
            <Box
                display={"flex"}
                justifyContent={"space-between"}
                w={{ base: "72%", md: "78%", xl: "1220px" }}
                mx={"auto"}
                px={4}
                fontSize={"20px"}
                letterSpacing={1}
            >
                {farm.reviews?.length === 0 ? "レビューの登録なし" : `${farm.reviews?.length}件`}

                <Link
                    href={route("review.create", { id: farm.id })} display="inline-flex"
                    alignItems="center"
                    _hover={{ color: "gray.500" }}
                ><EditIcon mr={1} boxSize={4} />
                    レビューを投稿する
                </Link>
            </Box>
            <ReviewList reviews={farm.reviews ?? []} />
        </Box>
    );
};

Detail.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Detail;
