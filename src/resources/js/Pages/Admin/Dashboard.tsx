import React from "react";
import { Box, Heading, Text, SimpleGrid, Flex, Stack, HStack, Divider, Badge, } from "@chakra-ui/react";
import { StarIcon } from "@chakra-ui/icons";
import MainLayout from "@/Layouts/MainLayout";


type FarmSummary = {
    id: number;
    name: string;
    created_at: string;
};

type ReviewSummary = {
    id: number;
    farm_rating: number | null;
    created_at: string;
    farm: {
        name: string;
    };
};

type DashboardProps = {
    farmCount: number;
    reviewCount: number;
    userCount: number;
    latestFarms: FarmSummary[];
    latestReviews: ReviewSummary[];
};


const Dashboard = ({ farmCount, reviewCount, userCount, latestFarms, latestReviews, }: DashboardProps) => {
    const StatCard = ({ label, value }: { label: string; value: number }) => (
        <Box bg="white" borderRadius="lg" boxShadow="sm" p={4}>
            <Text fontSize="xs" color="gray.500" mb={1}>
                {label}
            </Text>
            <Text fontSize="2xl" fontWeight="bold">
                {value.toLocaleString()}
            </Text>
        </Box>
    );

    const SectionHeader = ({
        title,
        count,
    }: {
        title: string;
        count: number;
    }) => (
        <Flex justify="space-between" align="center">
            <Heading fontSize="lg">{title}</Heading>
            <Text fontSize="sm" color="gray.500">
                （{count} 件）
            </Text>
        </Flex>
    );

    const formatDate = (value: string) => {
        return new Date(value).toLocaleDateString("ja-JP");
    };

    return (
        <Box maxW="1200px" mx="auto" py={8} px={{ base: 4, md: 6 }}>
            <Heading mb={6} fontSize={{ base: "2xl", md: "3xl" }}>
                管理者ダッシュボード
            </Heading>

            {/* 上部の統計カード */}
            <SimpleGrid columns={{ base: 1, sm: 3 }} spacing={4} mb={8}>
                <StatCard label="総ファーム数" value={farmCount} />
                <StatCard label="総レビュー数" value={reviewCount} />
                <StatCard label="総ユーザー数" value={userCount} />
            </SimpleGrid>

            {/* 最近のファーム */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={4} mb={6}>
                <SectionHeader
                    title="最近登録されたファーム"
                    count={latestFarms.length}
                />
                <Divider my={3} />
                <Stack spacing={2}>
                    {latestFarms.length === 0 && (
                        <Text fontSize="sm" color="gray.500">
                            まだファームが登録されていません。
                        </Text>
                    )}

                    {latestFarms.map((farm) => (
                        <Flex
                            key={farm.id}
                            justify="space-between"
                            fontSize="sm"
                        >
                            <Text>{farm.name}</Text>
                            <Text color="gray.500">
                                {formatDate(farm.created_at)}
                            </Text>
                        </Flex>
                    ))}
                </Stack>
            </Box>

            {/* 最近のレビュー */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={4}>
                <SectionHeader
                    title="最近のレビュー"
                    count={latestReviews.length}
                />
                <Divider my={3} />
                <Stack spacing={3}>
                    {latestReviews.length === 0 && (
                        <Text fontSize="sm" color="gray.500">
                            まだレビューがありません。
                        </Text>
                    )}

                    {latestReviews.map((review) => {
                        const score = review.farm_rating ?? 0; // null対策

                        return (
                            <Box key={review.id}>
                                <Flex justify="space-between" align="center">
                                    <Text fontSize="sm">
                                        ID: {review.id} / {review.farm.name}
                                    </Text>
                                    <Text fontSize="xs" color="gray.500">
                                        {formatDate(review.created_at)}
                                    </Text>
                                </Flex>

                                <HStack spacing={1} mt={1}>
                                    {Array.from({ length: 5 }).map((_, i) => (
                                        <StarIcon
                                            key={i}
                                            boxSize={3}
                                            color={
                                                i < score
                                                    ? "yellow.400"
                                                    : "gray.200"
                                            }
                                        />
                                    ))}
                                    <Badge ml={2} fontSize="xs">
                                        {score.toFixed(1)} / 5
                                    </Badge>
                                </HStack>
                            </Box>
                        );
                    })}
                </Stack>
            </Box>
        </Box>
    );
};

Dashboard.layout = (page: React.ReactNode) => (
    <MainLayout title="管理者ダッシュボード">{page}</MainLayout>
);

export default Dashboard;
