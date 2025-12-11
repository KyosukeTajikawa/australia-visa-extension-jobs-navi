import React, { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Link, Textarea, HStack, Text, Button, Flex, Image } from "@chakra-ui/react";
import { StarIcon, EditIcon, Icon } from "@chakra-ui/icons";
import { router } from "@inertiajs/react";
import FarmImageList from "@/Components/Organisms/FarmImageList";
import FarmList from "@/Components/Organisms/FarmList";
import FarmRatingGraph from "@/Components/Organisms/FarmRatingGraph";
import HeartFavorite from "@/Components/Organisms/HeartFavorite";
import { FaUserCircle } from "react-icons/fa";

type State = { id: number; name: string };
type FarmImages = { id: number; farm_id: number; url: string };
type Crops = { id: number; name: string };
type ReviewUser = { id: number; nickname: string; image?: ReviewUserImage | null }
type ReviewUserImage = { id: number; user_id: number; url: string }
type ReviewComments = { id: number; review_id: number; user_id: number; comment: string; created_at: string; image?: UserImage | null; user?: ReviewCommentUser; };
type UserImage = { id: number; user_id: number; url: string; user: ReviewCommentUser; }
type ReviewCommentUser = { id: number; nickname: string; image?: ReviewUserImage | null; };

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
    review_user?: ReviewUser | null;
    created_at: string;
    review_comments?: ReviewComments[] | null;
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
    const [showCommentForm, setShowCommentForm] = useState<number | null>(null);
    const [reviewComment, setReviewComment] = useState<Record<number, string>>({});
    const [showCommentReplyForm, setShowCommentReplyForm] = useState<number | null>(null);

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

    const handleChange = (reviewId: number, value: string) => {
        setReviewComment((e) => ({ ...e, [reviewId]: value }))
    }

    const handleSubmit = (e: React.FormEvent, reviewId: number) => {
        e.preventDefault();

        const text = (reviewComment[reviewId] ?? "").trim();
        if (text.length === 0) return;

        router.post(
            route("reviewComment.store", { review: reviewId }),
            { reviewComment: reviewComment[reviewId] },
            {
                preserveScroll: true,
                onSuccess: () => {
                    setReviewComment(prev => ({ ...prev, [reviewId]: "" }));
                    setShowCommentForm(null);
                    setShowCommentReplyForm(null);
                }
            }
        )
    }

    return (
        <Box w={{ base: "100%", sm: "460px", md: "750px", xl: "1000px" }} mx={"auto"}>

            {/* ファーム */}
            <Box mb={4}>
                <Box mx={"auto"} w={{ base: "90%", sm: "100%", md: "98%", xl: "95%" }}>
                    <Heading as="h2" py={2} color={"#4D4D4F"} fontSize={{ base: "36px", md: "50px" }} wordBreak="break-word">
                        {farm.name}
                    </Heading>
                </Box>

                {/* ファーム画像 */}
                <FarmImageList farm={farm} />

                {/* ファーム情報 */}
                <FarmList farm={farm} />
            </Box>

            {/* レビュー */}
            <Box
                mx={"auto"}
                w={{ base: "90%", sm: "100%", md: "98%", xl: "95%" }}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Heading mt={8} mb={2} as="h2" color={"#4D4D4F"} fontSize={{ base: "36px", md: "50px" }}>
                    レビュー
                </Heading>

                {/* レビュー評価グラフ */}
                <FarmRatingGraph reviews={farm.reviews ?? []} />
                <Box display="flex" justifyContent="space-between" mb={3}>
                    {farm.reviews?.length === 0 ? "レビューの登録なし" : `${farm.reviews?.length}件`}
                    <Link href={route("review.create", { id: farm.id })} display="inline-flex" alignItems="center" _hover={{ color: "gray.500" }}>
                        <EditIcon mr={1} boxSize={4} />レビューを投稿する
                    </Link>
                </Box>
            </Box>

            <Box fontSize={"20px"} letterSpacing={1}>
                {farm.reviews?.map((review) => (
                    <Box key={review.id} p={3} mb={3}>
                        <Flex alignItems={"center"} mb={1}>
                            <Image w={"25px"} h={"25px"} borderRadius={"full"} src={review.review_user?.image?.url ?? ""} fallback={<Icon w={"30px"} h={"30px"} as={FaUserCircle} color={"gray.500"} />} />
                            <Text ml={2}>{review.review_user?.nickname ?? "匿名ユーザー"}</Text>
                        </Flex>
                        <HStack>
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
                        <Text mb={1}>仕事のポジション：{review.work_position}</Text>
                        <Text mb={1}>支払種別：{review.pay_type === 1 ? "Hourly-Rate" : "Piece-Rate"}</Text>
                        <Text mb={1}>時給：{review.hourly_wage}</Text>
                        <Text mb={1}>応募方法：{renderApplicationMethod(review)}</Text>
                        <Text mb={1}>車の有無：{review.is_car_required === 1 ? "必要" : "不要"}</Text>
                        <Text mb={1}>開始日: {review.start_date}</Text>
                        <Text mb={1}>終了日: {review.end_date}</Text>
                        <Text whiteSpace="pre-wrap">コメント <br />{review.comment}</Text>

                        <Flex justifyContent={"flex-end"} alignItems="center">

                            {/* レビューお気に入り */}
                            <HeartFavorite reviewId={review.id} />
                            <Button ml={{ md: 5 }} mr={5} mt={2} bg={"green.800"} _hover={{ bg: "green.700" }} color={"white"} onClick={() => setShowCommentForm(showCommentForm === review.id ? null : review.id)}>
                                コメントする
                            </Button>
                        </Flex>
                        <form onSubmit={(e) => handleSubmit(e, review.id)}>
                            {showCommentForm === review.id && (
                                <>
                                    <Textarea isRequired mt={4} name="reviewComment" value={reviewComment[review.id] ?? ""} onChange={(e) => handleChange(review.id, e.target.value)} placeholder="コメントを書いてください" />
                                    <Button mt={2} type="submit" bg="#388E3C"
                                        _hover={{ bg: "#2E7D32" }}
                                        color="#FFFFFF">登録</Button>
                                </>
                            )}
                        </form>

                        {/* レビュー返信 */}
                        <Box w={{ base: "90%", sm: "380px", md: "650px", xl: "850px" }} mx={"auto"} >
                            {review.review_comments?.map((review_comment) => (
                                <Box key={review_comment.id}>
                                    <Box mt={5} bg={"#e2e8f0"} border={"1px solid none"} borderRadius={"md"} p={4}>
                                        <Flex justifyContent={"space-between"}>
                                            <HStack>
                                                <Image w="25px" h="25px" borderRadius="full" src={review_comment.user?.image?.url ?? ""}
                                                    fallback={
                                                        <Icon w="30px" h="30px" as={FaUserCircle} color="gray.500" />
                                                    }
                                                />
                                                <Text>{review_comment.user?.nickname}</Text>
                                            </HStack>

                                            <Text mb={1} color="gray.500" fontSize="16px" textAlign={"center"}>
                                                {new Date(review_comment.created_at).toLocaleDateString("ja-JP")}
                                            </Text>
                                        </Flex>
                                        <Text whiteSpace="pre-wrap">{review_comment.comment}</Text>
                                    </Box>
                                    <Link as={Button} fontWeight={"normal"} bg={"none"} color="gray.500" fontSize="18px" _hover={{ textDecoration: "none", bg: "none", opacity: 0.7 }} onClick={() => setShowCommentReplyForm(showCommentReplyForm === review_comment.id ? null : review_comment.id)}>
                                        ↪︎返信する
                                    </Link>
                                    <Box>
                                        {showCommentReplyForm === review_comment.id && (
                                            <>
                                                <form onSubmit={(e) => handleSubmit(e, review.id)}>
                                                    <Textarea isRequired mt={4} name="reviewComment" value={reviewComment[review.id] ?? ""} onChange={(e) => handleChange(review.id, e.target.value)} placeholder="コメントを書いてください" />
                                                    <Button mt={2} type="submit">登録</Button>
                                                </form>
                                            </>
                                        )}
                                    </Box>
                                </Box>
                            ))}
                        </Box>
                    </Box>
                ))}
            </Box>
        </Box>
    );
};

Detail.layout = (page: React.ReactNode) => (
    <MainLayout title="ファーム詳細">{page}</MainLayout>
);

export default Detail;
