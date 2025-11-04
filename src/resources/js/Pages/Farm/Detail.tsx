import React, { useMemo } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, HStack, Text, Button, VStack, Progress, } from "@chakra-ui/react";
import { StarIcon, EditIcon } from "@chakra-ui/icons";
import { router } from "@inertiajs/react";
import FarmImageList from "@/Components/Organisms/FarmImageList";
import FarmList from "@/Components/Organisms/FarmList";

type State = { id: number; name: string };
type FarmImages = { id: number; farm_id: number; url: string };
type Crops = { id: number; name: string };

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
    other_application_method?: string | null;
    application_method_other?: string | null;
    application_method?: { id: number; name: string } | null;
    review_user?: { id: number; nickname: string } | null;
    created_at: string;
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

const RatingSummary: React.FC<{ reviews?: Review[] }> = ({ reviews }) => {
    const ratings = reviews?.map((r) => r.farm_rating) ?? [];
    const total = ratings.length;

    const { avg, percents } = useMemo(() => {
        if (total === 0) return { avg: 0, counts: [0, 0, 0, 0, 0], percents: [0, 0, 0, 0, 0] };

        const avg = Math.round((ratings.reduce((a, b) => a + b, 0) / total) * 10) / 10;
        const counts = [5, 4, 3, 2, 1].map((n) => ratings.filter((r) => r === n).length);
        const max = Math.max(...counts);
        const percents = counts.map((c) => (max ? (c / max) * 100 : 0));
        return { avg, counts, percents };
    }, [ratings, total]);

    return (
        <HStack align="flex-start" spacing={8} mt={4} mb={6}>
            <VStack align="flex-start">
                <Text fontSize="6xl" fontWeight="bold" lineHeight="1">{avg.toFixed(1)}</Text>
                <HStack>
                    {Array(5)
                        .fill(0)
                        .map((_, i) => (
                            <StarIcon
                                key={i}
                                color={i < Math.round(avg) ? "green.500" : "gray.300"}
                                boxSize={5}
                            />
                        ))}
                </HStack>
                <Text color="gray.600" fontSize="sm">{total.toLocaleString()} 件のレビュー</Text>
            </VStack>

            <VStack flex="1" spacing={2} align="stretch">
                {[5, 4, 3, 2, 1].map((star, idx) => (
                    <HStack key={star} spacing={3}>
                        <Text w="16px" textAlign="right" fontSize="sm">{star}</Text>
                        <Progress
                            value={percents[idx]}
                            flex="1"
                            size="md"
                            borderRadius="md"
                            colorScheme="green"
                            bg="gray.200"
                        />
                    </HStack>
                ))}
            </VStack>
        </HStack>
    );
};

const Detail = ({ farm }: DetailProps) => {
    const OTHER_ID = 99;
    const OTHER_LABEL = "その他";

    const renderApplicationMethod = (review: Review): string => {
        const name =
            (review.application_method_name ?? review.application_method?.name ?? "").trim();

        const other =
            (review.application_method_other ?? review.other_application_method ?? "").trim();

        const isOther = review.application_method_id === OTHER_ID || name === OTHER_LABEL;

        if (isOther) {
            return other ? `${OTHER_LABEL}：「${other}」` : OTHER_LABEL;
        }
        if (name) return name;
        return "未入力";
    };

    return (
        <Box w={{ base: "100%", sm: "460px", md: "750px", xl: "1000px" }} mx={"auto"}>
            {/* ファーム情報 */}
            <Box mb={4}>
                <Box
                mx={"auto"}
                w={{ base: "90%", sm: "100%", md: "98%", xl: "95%" }}
                    >
                    <Heading
                        as="h2"
                        py={2}
                        fontSize={{ base: "36px", md: "50px" }}
                        wordBreak="break-word"
                    >
                        {farm.name}
                    </Heading>
                </Box>
                <FarmImageList farm={farm} />
                <FarmList farm={farm} />
            </Box>

            {/* レビュー */}
            <Box
                mx={"auto"}
                w={{ base: "90%", sm: "100%", md: "98%", xl: "95%" }}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Heading mt={8} mb={2} as="h2" fontSize={{ base: "36px", md: "50px" }}>
                    レビュー
                </Heading>

                <RatingSummary reviews={farm.reviews} />

                <Box display="flex" justifyContent="space-between" mb={3}>
                    {farm.reviews?.length === 0 ? "レビューの登録なし" : `${farm.reviews?.length}件`}
                    <Link
                        href={route("review.create", { id: farm.id })}
                        display="inline-flex"
                        alignItems="center"
                        _hover={{ color: "gray.500" }}
                    >
                        <EditIcon mr={1} boxSize={4} />
                        レビューを投稿する
                    </Link>
                </Box>
            </Box>

            {/* 各レビュー */}
            <Box
                fontSize={"20px"}
                letterSpacing={1}
            >
                {
                    farm.reviews?.map((review) => (
                        <Box
                            key={review.id}
                            p={3}
                            mb={3}
                        >
                            <Text mb={1}>{review.review_user?.nickname ?? "匿名ユーザー"}</Text>
                            <HStack>
                            <HStack mb={2} align="stretch">
                                    <HStack>
                                    {Array(5)
                                        .fill("")
                                        .map((_, i) => (
                                            <StarIcon
                                                key={i}
                                                color={i < review.farm_rating ? "green.500" : "gray.300"}
                                                fontSize={"12px"}
                                            />
                                        ))}
                                </HStack>
                            </HStack>
                            <Text mb={1} color="gray.500" fontSize="16px" textAlign={"center"}>
                                {new Date(review.created_at).toLocaleDateString("ja-JP")}
                            </Text>
                            </HStack>
                            <Text mb={1}>仕事のポジション{review.work_position}</Text>
                            <Text mb={1}>
                                支払種別：{review.pay_type === 1 ? "Hourly-Rate" : "Piece-Rate"}
                            </Text>
                            <Text mb={1}>時給：{review.hourly_wage}</Text>
                            <Text mb={1}>応募方法：{renderApplicationMethod(review)}</Text>
                            <Text mb={1}>
                                車の有無：{review.is_car_required === 1 ? "必要" : "不要"}
                            </Text>
                            <HStack mb={1}>
                                <Text>開始日: {review.start_date}</Text>
                                <Text>〜</Text>
                                <Text>終了日: {review.end_date}</Text>
                            </HStack>
                            <Text>{review.comment}</Text>
                            <Button
                                mt={2}
                                colorScheme="green"
                                onClick={() => router.post(`/review/${review.id}/favorites`)}
                            >
                                お気に入り
                            </Button>
                        </Box>
                    ))
                }
            </Box>
        </Box >
    );
};

Detail.layout = (page: React.ReactNode) => (
    <MainLayout title="ファーム情報サイト">{page}</MainLayout>
);

export default Detail;
