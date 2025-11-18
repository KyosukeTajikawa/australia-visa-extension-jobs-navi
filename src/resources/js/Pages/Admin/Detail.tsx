import React from "react";
import { Box, Heading, Text, Flex, Stack, HStack, Image, Badge, Button, Divider, AlertDialog, AlertDialogBody, AlertDialogFooter, AlertDialogHeader, AlertDialogContent, AlertDialogOverlay, useDisclosure, Icon } from "@chakra-ui/react";
import { StarIcon } from "@chakra-ui/icons";
import { router, Link } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import { FaUserCircle } from "react-icons/fa";

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
    nickname: string;
    email: string;
    created_at: string;
    image?: UserImage | null;
    farms: Farm[];
    user_reviews: Review[];
};

type Props = {
    user: UserDetail;
};

type DeleteTarget =
    | { kind: "farm"; id: number }
    | { kind: "review"; id: number }
    | null;

const formatDate = (value: string) =>
    new Date(value).toLocaleDateString("ja-JP");

const formatDateTime = (value: string) =>
    new Date(value).toLocaleString("ja-JP");

const Detail: React.FC<Props> = ({ user }) => {
    const { isOpen, onOpen, onClose } = useDisclosure();
    const cancelRef = React.useRef<HTMLButtonElement>(null);

    const [deleteTarget, setDeleteTarget] = React.useState<DeleteTarget>(null);

    const farmCount = user.farms.length;
    const reviewCount = user.user_reviews.length;

    const openFarmDeleteDialog = (farmId: number) => {
        setDeleteTarget({ kind: "farm", id: farmId });
        onOpen();
    };

    const openReviewDeleteDialog = (reviewId: number) => {
        setDeleteTarget({ kind: "review", id: reviewId });
        onOpen();
    };

    const handleConfirmDelete = () => {
        if (!deleteTarget) return;

        if (deleteTarget.kind === "farm") {
            router.delete(route("admin.farm.destroy", deleteTarget.id), {
                onSuccess: () => {
                    onClose();
                    setDeleteTarget(null);
                },
            });
        }

        if (deleteTarget.kind === "review") {
            router.delete(route("admin.review.destroy", deleteTarget.id), {
                onSuccess: () => {
                    onClose();
                    setDeleteTarget(null);
                },
            });
        }
    };

    return (
        <Box maxW="1200px" mx="auto" py={8} px={{ base: 4, md: 6 }}>
            <AlertDialog
                isOpen={isOpen}
                leastDestructiveRef={cancelRef}
                onClose={() => {
                    onClose();
                    setDeleteTarget(null);
                }}
            >
                <AlertDialogOverlay>
                    <AlertDialogContent w="90%">
                        <AlertDialogHeader fontSize="lg" fontWeight="bold">
                            {deleteTarget?.kind === "farm"
                                ? "ファーム削除"
                                : deleteTarget?.kind === "review"
                                    ? "レビュー削除"
                                    : "削除確認"}
                        </AlertDialogHeader>

                        <AlertDialogBody>
                            {deleteTarget?.kind === "farm" &&
                                "このファームを削除しますか？"}
                            {deleteTarget?.kind === "review" &&
                                "このレビューを削除しますか？"}
                        </AlertDialogBody>

                        <AlertDialogFooter>
                            <Button ref={cancelRef} onClick={onClose} mr={5}>
                                戻る
                            </Button>
                            <Button colorScheme="red" onClick={handleConfirmDelete}>
                                削除
                            </Button>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialogOverlay>
            </AlertDialog>
            <Flex justifyContent={"space-between"} >
                <Heading mb={6}>ユーザー詳細</Heading>
                <Button
                    as={Link}
                    href={"/admin/user"}
                    fontWeight={"bold"}
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                    w={{ md: "150px" }}
                >
                    戻る
                </Button>

            </Flex>

            {/* --------------- ユーザー情報 --------------- */}
            <Box
                bg="white"
                borderRadius="lg"
                boxShadow="sm"
                p={5}
                mb={8}
                display="flex"
                flexDirection={{ base: "column", md: "row" }}
                gap={4}
            >
                <Image
                    src={user.image?.url ?? ""}
                    fallback={
                        <Icon as={FaUserCircle} w="150px" h="150px" color="gray.500" />
                    }
                    w="150px"
                    h="150px"
                    objectFit="cover"
                    borderRadius="full"
                />

                <Box flex="1">
                    <Flex justify="space-between">
                        <Box>
                            <HStack spacing={3}>
                                <Text fontSize="xl" fontWeight="bold">
                                    {user.nickname}
                                </Text>
                                <Badge colorScheme="green">ID: {user.id}</Badge>
                            </HStack>
                            <Text fontSize="sm" color="gray.600">
                                {user.email}
                            </Text>
                        </Box>

                        <Text fontSize="sm" color="gray.600">
                            登録日：{formatDate(user.created_at)}
                        </Text>
                    </Flex>

                    <HStack spacing={6} mt={2}>
                        <Text>作成したファーム数：<b>{farmCount}</b></Text>
                        <Text>投稿したレビュー数：<b>{reviewCount}</b></Text>
                    </HStack>
                </Box>
            </Box>

            {/* --------------- 作成したファーム一覧 --------------- */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={5} mb={8}>
                <Flex justify="space-between" mb={3}>
                    <Heading as="h2" fontSize="lg">作成したファーム</Heading>
                    <Text color="gray.500">（{farmCount} 件）</Text>
                </Flex>

                <Divider mb={3} />

                <Stack spacing={2}>
                    {farmCount === 0 && (
                        <Text color="gray.500">作成したファームはありません。</Text>
                    )}

                    {user.farms.map((farm) => (
                        <Flex
                            key={farm.id}
                            py={2}
                            borderBottom="1px solid"
                            borderColor="gray.100"
                        >
                            <Box flex="1">
                                <Text>{farm.name}</Text>
                                <Text fontSize="xs" color="gray.500">
                                    作成日：{formatDate(farm.created_at)}
                                </Text>
                            </Box>

                            <HStack spacing={2}>
                                <Button
                                    size="sm"
                                    variant="outline"
                                    colorScheme="green"
                                    onClick={() => router.get(`/admin/farm/${farm.id}/edit`)}
                                >
                                    編集
                                </Button>

                                <Button
                                    size="sm"
                                    variant="outline"
                                    colorScheme="red"
                                    onClick={() => openFarmDeleteDialog(farm.id)}
                                >
                                    削除
                                </Button>
                            </HStack>
                        </Flex>
                    ))}
                </Stack>
            </Box>

            {/* --------------- 投稿したレビュー一覧 --------------- */}
            <Box bg="white" borderRadius="lg" boxShadow="sm" p={5}>
                <Flex justify="space-between" mb={3}>
                    <Heading as="h2" fontSize="lg">投稿したレビュー</Heading>
                    <Text color="gray.500">（{reviewCount} 件）</Text>
                </Flex>

                <Divider mb={3} />

                <Stack spacing={3}>
                    {reviewCount === 0 && (
                        <Text color="gray.500">レビューはありません。</Text>
                    )}

                    {user.user_reviews.map((review) => {
                        const score = review.farm_rating ?? 0;

                        return (
                            <Box key={review.id} borderWidth="1px" borderRadius="md" p={3}>
                                <Flex justify="space-between" mb={1}>
                                    <Box>
                                        <Text fontWeight="medium">
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
                                        <HStack spacing={1} mt={1}>
                                            {Array.from({ length: 5 }).map((_, i) => (
                                                <StarIcon
                                                    key={i}
                                                    boxSize={3}
                                                    color={i < score ? "yellow.400" : "gray.200"}
                                                />
                                            ))}
                                            <Badge fontSize="xs">
                                                {score.toFixed(1)} / 5
                                            </Badge>
                                        </HStack>
                                    </Box>
                                </Flex>

                                <Text mb={2} whiteSpace="pre-wrap">
                                    {review.comment}
                                </Text>

                                <HStack spacing={2} justify="flex-end">
                                    <Button
                                        size="xs"
                                        variant="outline"
                                        colorScheme="green"
                                        onClick={() => router.get(`/admin/review/${review.id}/edit`)}
                                    >
                                        編集
                                    </Button>
                                    <Button
                                        size="xs"
                                        variant="outline"
                                        colorScheme="red"
                                        onClick={() => openReviewDeleteDialog(review.id)}
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

Detail.layout = (page: React.ReactNode) => (
    <MainLayout title="ユーザー詳細">{page}</MainLayout>
);

export default Detail;
