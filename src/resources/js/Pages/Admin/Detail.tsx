import React from "react";
import { Box, Heading, Text, Flex, Stack, HStack, Avatar, Badge, Button, Divider, } from "@chakra-ui/react";
import { StarIcon } from "@chakra-ui/icons";
import { router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";

// ---------- 型定義 ----------

type UserImage = {
    id: number;
    url: string;
};

type Farm = {
    id: number;
    name: string;
    created_at: string;
};

type Review = {
    id: number;
    farm_rating: number | null;
    comment: string;
    created_at: string;
    farm: {
        id: number;
        name: string;
    };
};

type UserDetail = {
    id: number;
    name: string;
    email: string;
    created_at: string;
    image?: UserImage | null;
    farms: Farm[];
    // Laravel 側のリレーション名が userReviews の場合、
    // Inertia では user_reviews というキーで来る想定
    user_reviews: Review[];
};

type Props = {
    user: UserDetail;
};

// ---------- ヘルパー ----------

const formatDate = (value: string) =>
    new Date(value).toLocaleDateString("ja-JP");

const formatDateTime = (value: string) =>
    new Date(value).toLocaleString("ja-JP", {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
    });

// ---------- メインコンポーネント ----------

const UserDetailPage: React.FC<Props> = ({ user }) => {
    const farmCount = user.farms?.length ?? 0;
    const reviewCount = user.user_reviews?.length ?? 0;

    // TODO: ルート名・URL はあなたのアプリに合わせて変更してください
    const handleEditFarm = (farmId: number) => {
        router.get(`/farm/${farmId}/edit`);
        // 例）router.get(route("farm.edit", farmId));
    };

    const handleDeleteFarm = (farmId: number) => {
        if (!confirm("このファームを削除しますか？")) return;
        router.delete(`/farm/${farmId}`);
        // 例）router.delete(route("farm.destroy", farmId));
    };

    const handleEditReview = (reviewId: number) => {
        router.get(`/review/${reviewId}/edit`);
        // 例）router.get(route("review.edit", reviewId));
    };

    const handleDeleteReview = (reviewId: number) => {
        if (!confirm("このレビューを削除しますか？")) return;
        router.delete(`/review/${reviewId}`);
        // 例）router.delete(route("review.destroy", reviewId));
    };

    return (
        <Box maxW="1200px" mx="auto" py={8} px={{ base: 4, md: 6 }}>
            {/* タイトル */}
            <Heading mb={6} fontSize={{ base: "2xl", md: "3xl" }} color="gray.700">
                ユーザー詳細
            </Heading>

            {/* ユーザー情報カード */}
            <Box
                bg="white"
                borderRadius="lg"
                boxShadow="sm"
                p={5}
                mb={8}
                display="flex"
                alignItems={{ base: "flex-start", md: "center" }}
                flexDirection={{ base: "column", md: "row" }}
                gap={4}
            >
                <Avatar
                    size="xl"
                    src={user.image?.url ?? undefined}
                    name={user.name}
                />

                <Box flex="1">
                    <Flex justify="space-between" align="flex-start" mb={2}>
                        <Box>
                            <HStack spacing={3} mb={1}>
                                <Text fontSize="xl" fontWeight="bold">
                                    {user.name}
                                </Text>
                                <Badge colorScheme="green">ID: {user.id}</Badge>
                            </HStack>
                            <Text fontSize="sm" color="gray.600">
                                {user.email}
                            </Text>
                        </Box>

                        <Box textAlign="right" fontSize="sm" color="gray.600">
                            <Text>登録日：{formatDate(user.created_at)}</Text>
                        </Box>
                    </Flex>

                    <HStack spacing={6} mt={2}>
                        <Text fontSize="sm" color="gray.700">
                            作成したファーム数：<b>{farmCount}</b>
                        </Text>
                        <Text fontSize="sm" color="gray.700">
                            投稿したレビュー数：<b>{reviewCount}</b>
                        </Text>
                    </HStack>
                </Box>
            </Box>

            {/* 作成したファーム一覧 */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={5} mb={8}>
                <Flex justify="space-between" align="center" mb={3}>
                    <Heading as="h2" fontSize="lg">
                        作成したファーム
                    </Heading>
                    <Text fontSize="sm" color="gray.500">
                        （{farmCount} 件）
                    </Text>
                </Flex>

                <Divider mb={3} />

                <Stack spacing={2}>
                    {farmCount === 0 && (
                        <Text fontSize="sm" color="gray.500">
                            このユーザーが作成したファームはありません。
                        </Text>
                    )}

                    {user.farms.map((farm) => (
                        <Flex
                            key={farm.id}
                            py={2}
                            px={1}
                            align="center"
                            borderBottom="1px solid"
                            borderColor="gray.100"
                            _last={{ borderBottom: "none" }}
                        >
                            <Box flex="1">
                                <Text fontSize="sm" fontWeight="medium">
                                    {farm.name}
                                </Text>
                                <Text fontSize="xs" color="gray.500">
                                    作成日：{formatDate(farm.created_at)}
                                </Text>
                            </Box>

                            <HStack spacing={2}>
                                <Button
                                    size="sm"
                                    variant="outline"
                                    colorScheme="green"
                                    onClick={() => handleEditFarm(farm.id)}
                                >
                                    編集
                                </Button>
                                <Button
                                    size="sm"
                                    colorScheme="red"
                                    variant="outline"
                                    onClick={() => handleDeleteFarm(farm.id)}
                                >
                                    削除
                                </Button>
                            </HStack>
                        </Flex>
                    ))}
                </Stack>
            </Box>

            {/* 投稿したレビュー一覧 */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={5}>
                <Flex justify="space-between" align="center" mb={3}>
                    <Heading as="h2" fontSize="lg">
                        投稿したレビュー
                    </Heading>
                    <Text fontSize="sm" color="gray.500">
                        （{reviewCount} 件）
                    </Text>
                </Flex>

                <Divider mb={3} />

                <Stack spacing={3}>
                    {reviewCount === 0 && (
                        <Text fontSize="sm" color="gray.500">
                            このユーザーが投稿したレビューはありません。
                        </Text>
                    )}

                    {user.user_reviews.map((review) => {
                        const score = review.farm_rating ?? 0;

                        return (
                            <Box
                                key={review.id}
                                borderWidth="1px"
                                borderRadius="md"
                                borderColor="gray.100"
                                p={3}
                            >
                                <Flex justify="space-between" align="flex-start" mb={1}>
                                    <Box>
                                        <Text fontSize="sm" fontWeight="medium">
                                            {review.farm.name}
                                        </Text>
                                        <Text fontSize="xs" color="gray.500">
                                            レビューID: {review.id}
                                        </Text>
                                    </Box>
                                    <Box textAlign="right">
                                        <Text fontSize="xs" color="gray.500">
                                            投稿日：{formatDateTime(review.created_at)}
                                        </Text>
                                        <HStack spacing={1} justify="flex-end" mt={1}>
                                            {Array.from({ length: 5 }).map((_, i) => (
                                                <StarIcon
                                                    key={i}
                                                    boxSize={3}
                                                    color={i < score ? "yellow.400" : "gray.200"}
                                                />
                                            ))}
                                            <Badge ml={1} fontSize="xs">
                                                {score.toFixed(1)} / 5
                                            </Badge>
                                        </HStack>
                                    </Box>
                                </Flex>

                                <Text fontSize="sm" color="gray.700" mb={2} whiteSpace="pre-wrap">
                                    {review.comment}
                                </Text>

                                <HStack spacing={2} justify="flex-end">
                                    <Button
                                        size="xs"
                                        variant="outline"
                                        colorScheme="green"
                                        onClick={() => handleEditReview(review.id)}
                                    >
                                        編集
                                    </Button>
                                    <Button
                                        size="xs"
                                        variant="outline"
                                        colorScheme="red"
                                        onClick={() => handleDeleteReview(review.id)}
                                    >
                                        削除
                                    </Button>
                                </HStack>
                            </Box>
                        );
                    })}
                </Stack>
            </Box>
        </Box>
    );
};

// レイアウト設定
UserDetailPage.layout = (page: React.ReactNode) => (
    <MainLayout title="ユーザー詳細">{page}</MainLayout>
);

export default UserDetailPage;
