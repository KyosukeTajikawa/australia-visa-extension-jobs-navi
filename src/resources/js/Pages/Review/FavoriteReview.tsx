import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, HStack, Text} from "@chakra-ui/react";
import { StarIcon } from '@chakra-ui/icons';

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

type FavoriteReviewProps = {
    reviews: Review[];
}

const FavoriteReview = ({ reviews }: FavoriteReviewProps) => {
    return (
        <Box>
            <Heading as={"h1"}>お気に入りレビュー一覧</Heading>
            {reviews?.map((review) => (
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
    )
}

FavoriteReview.layout = (page: React.ReactNode) => (<MainLayout title="お気に入りレビュー">{page}</MainLayout>)
export default FavoriteReview;
