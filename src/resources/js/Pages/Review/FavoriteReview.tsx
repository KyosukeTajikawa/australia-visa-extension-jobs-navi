import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, HStack, Text, Link, Image, Flex } from "@chakra-ui/react";
import { StarIcon, Icon } from '@chakra-ui/icons';
import { FaUserCircle } from "react-icons/fa";
import HeartFavorite from "@/Components/Organisms/HeartFavorite";

type Farm = { id: number; name: string; }
type ReviewComments = { id: number; review_id: number; user_id: number; comment: string; created_at: string; };
type ReviewUser = { id: number; nickname: string; image?: ReviewUserImage | null }
type ReviewUserImage = { id: number; user_id: number; url: string }

type Review = {
    id: number;
    farm_rating: number;
    work_position: string;
    pay_type: number;
    hourly_wage: number;
    is_car_required: number;
    comment: string;
    start_date: string;
    end_date: string;
    application_method_id?: number | null;
    application_method_name?: string | null;
    application_method_other?: string | null;
    application_method?: { id: number; name: string } | null;
    created_at: string;
    is_favorite?: boolean;
    review_comments?: ReviewComments[] | null;
    farm: Farm;
    review_user?: ReviewUser | null;
};

type FavoriteReviewProps = {
    reviews: Review[];
}

const FavoriteReview = ({ reviews }: FavoriteReviewProps) => {
    const OtherId = 99;
    const OtherLabel = "その他";

    const renderApplicationMethod = (review: Review): string => {
        const name = (review.application_method_name ?? review.application_method?.name ?? "").trim();

        const other = (review.application_method_other ?? "").trim();

        const isOther = review.application_method_id === OtherId || name === OtherLabel;

        if (isOther) {
            return other ? other : OtherLabel;
        }
        return name;
    };
    return (
        <Box bg={"#FAF7F0"} w={{ base: "90%", sm: "460px", md: "750px", xl: "1000px" }} mx={"auto"}>
            <Heading as={"h1"} mt={5} color={"#4D4D4F"}>お気に入りレビュー一覧</Heading>

            {reviews?.map((review) => (
                <Box key={review.id} fontSize={"20px"} mt={5}>
                    <Link href={`/farm/${review.farm.id}`} _hover={{ opacity: 0.8 }}>
                        <Heading as={"h2"} fontSize={"30px"}>{review.farm.name}</Heading>
                    </Link>
                    <Flex alignItems={"center"} my={3}>
                        <Image w={"25px"} h={"25px"} borderRadius={"full"} src={review.review_user?.image?.url ?? ""} fallback={<Icon as={FaUserCircle} w={"30px"} h={"30px"} color={"gray.500"} />} />
                        <Text ml={2}>{review.review_user?.nickname ?? "匿名ユーザー"}</Text>
                    </Flex>
                    <HStack mt={2}>
                        <HStack mb={2} align="stretch">
                            <HStack>
                                {Array(5).fill("").map((_, i) => (
                                    <StarIcon key={i} color={i < review.farm_rating ? "green.500" : "gray.300"} fontSize={"12px"} />
                                ))}
                            </HStack>
                        </HStack>
                        <Text mb={1} color="gray.500" fontSize="16px" textAlign={"center"}>
                            {new Date(review.created_at).toLocaleDateString("ja-JP")}
                        </Text>
                    </HStack>
                    <Text mb={1}>仕事のポジション{review.work_position}</Text>
                    <Text mb={1}>支払種別：{review.pay_type === 1 ? "Hourly-Rate" : "Piece-Rate"}</Text>
                    <Text mb={1}>時給：{review.hourly_wage}</Text>
                    <Text mb={1}>応募方法：{renderApplicationMethod(review)}</Text>
                    <Text mb={1}>車の有無：{review.is_car_required === 1 ? "必要" : "不要"}</Text>
                    <HStack mb={1}>
                        <Text>開始日: {review.start_date}</Text><Text>〜</Text><Text>終了日: {review.end_date}</Text>
                    </HStack>
                    <Text whiteSpace="pre-wrap" mb={2}>{review.comment}</Text>
                    {/* レビューお気に入り */}
                    <Flex justifyContent={"flex-end"}>
                    <HeartFavorite reviewId={review.id} initial={true}/>
                    </Flex>
                </Box>
            ))}
        </Box>
    )
}

FavoriteReview.layout = (page: React.ReactNode) => (<MainLayout title="お気に入りレビュー">{page}</MainLayout>)
export default FavoriteReview;
