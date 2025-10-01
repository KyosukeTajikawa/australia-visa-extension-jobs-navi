import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, HStack, Image, Text, } from "@chakra-ui/react";
import { StarIcon, EditIcon } from '@chakra-ui/icons';

type State = {
    id: number;
    name: string;
};

type Review = {
    id: number;
    type2: string;
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
    phone_number: string;
    email: string;
    description: string;
    street_address: string;
    suburb: string;
    postcode: string;
    state: State;
    reviews: Review[];
};

type DetailProps = { farm: Farm };

const Detail = ({ farm }: DetailProps) => {
    return (
        <Box m={4}>
            {/* ファーム */}
            <Box mb={4}>
                <Heading as={"h2"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>{farm.name}</Heading>
            </Box>
            <Box mb={4}>
                <Image src="https://placehold.co/300x300" boxSize={"300px"} alt={farm.name} objectFit={"contain"} />
            </Box>
                <Text mb={1}>電話番号:{farm.phone_number}</Text>
                <Text mb={1}>メールアドレス:{farm.email}</Text>
            <HStack mb={2}>
                <Text>住所:{farm.street_address}</Text>
                <Text>{farm.suburb}</Text>
                <Text>{farm.state.name}</Text>
                <Text>{farm.postcode}</Text>
            </HStack>
            <Box>
                <Text>{farm.description}</Text>
            </Box>


            {/* レビュー */}
            <Box>
                <Heading mt={8} as={"h2"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>レビュー</Heading>
            </Box>
            <Box display={"flex"} justifyContent={"space-between"}>
            {farm.reviews.length === 0 ? "レビューの登録なし" : `${farm.reviews.length}件`}
                <Link href="#" display="inline-flex" alignItems="center" _hover={{color: "gray.500"}}><EditIcon mr={1} boxSize={4} />レビューを投稿する</Link>
            </Box>
            {farm.reviews.map((review) => (
                <Box key={review.id} border={"1px"} borderRadius={"md"} borderColor={"gray.300"} boxShadow={"md"}>
                    <Text mb={1}>仕事のポジション：{review.work_position}</Text>
                    <Text mb={1}>支払種別：{review.pay_type === 1 ? "Hourly-Rate" : "Piece-Rate"}</Text>
                    <Text mb={1}>時給：{review.hourly_wage}</Text>
                    <Text mb={1}>車の有無：{review.is_car_required === 1 ? "必要" : "不要"}</Text>
                    <HStack mb={1}>
                        <Text>開始日:{review.start_date}</Text>
                        <Text>〜</Text>
                        <Text>終了日:{review.end_date}</Text>
                    </HStack>
                    <HStack mb={1} align={"stretch"}>
                        <Text>仕事内容　　</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.work_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </HStack>
                    <HStack mb={2} align={"stretch"}>
                        <Text>給料　　　　</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.salary_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </HStack>
                    <HStack mb={2} align={"stretch"}>
                        <Text>労働時間　　</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.hour_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </HStack>
                    <HStack mb={2} align={"stretch"}>
                        <Text>人間関係　　</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.relation_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </HStack>
                    <HStack mb={2} align={"stretch"}>
                        <Text>総合評価　　</Text>
                        <HStack>
                            {Array(5).fill("").map((_, i) => (
                                <StarIcon key={i} color={i < review.overall_rating ? "yellow.500" : "gray.300"} />
                            ))}
                        </HStack>
                    </HStack>
                        <Text>コメント</Text>
                        <Text>{review.comment}</Text>
                </Box>
            ))}
        </Box>
    );
};

Detail.layout = (page: React.ReactNode) => (<MainLayout title="ファーム情報サイト">{page}</MainLayout>);
export default Detail;
