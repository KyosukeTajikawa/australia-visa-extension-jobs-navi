import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, VStack, HStack, Button, Image, AlertDialog, AlertDialogBody, AlertDialogFooter, AlertDialogHeader, AlertDialogContent, AlertDialogOverlay, useDisclosure } from "@chakra-ui/react";
import { Icon } from '@chakra-ui/icons';
import { Link, router } from "@inertiajs/react";
import { FaUserCircle } from "react-icons/fa";

type UserImage = {
    id: number;
    user_id: number;
    url: string;
}

type User = {
    id: number;
    nickname: string;
    email: string;
    gender: number | null;
    birthday?: string | "";
    image: UserImage | null;
};

type ProfileProps = {
    user: User;
}

const Profile = ({ user }: ProfileProps) => {
    const { isOpen, onOpen, onClose } = useDisclosure()
    const cancelRef = React.useRef<HTMLButtonElement>(null)

    return (
        <Box w={{ base: "90%", md: "60%" }} mx={"auto"} mt={"150px"} mb={10}>

            <AlertDialog
                isOpen={isOpen}
                leastDestructiveRef={cancelRef}
                onClose={onClose}
            >
                <AlertDialogOverlay>
                    <AlertDialogContent w={"90%"}>
                        <AlertDialogHeader fontSize='lg' fontWeight='bold'>
                            ユーザー削除
                        </AlertDialogHeader>

                        <AlertDialogBody>
                            本当に削除しますか？
                        </AlertDialogBody>

                        <AlertDialogFooter>
                            <Button ref={cancelRef} onClick={onClose} mr={5}>
                                戻る
                            </Button>
                            <Button ml={3} colorScheme='red' onClick={() => router.delete(route("user.destroy"), { onSuccess: () => { onClose() } })} >
                                削除
                            </Button>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialogOverlay>
            </AlertDialog>

            <VStack fontSize={"20px"} mx={"auto"}>
                <Heading as={"h3"} mb={4} fontWeight={"bold"} fontSize={{ base: "18px", md: "24px" }} color={"gray.600"}>プロフィール</Heading>
                <Box>
                    <Image src={user.image?.url ?? ""} fallback={<Icon as={FaUserCircle} w={{ base: "120px", lg: "200px" }} h={{ base: "120px", lg: "200px" }} color={"gray.500"} />}
                        w={{ base: "120px", lg: "200px" }} h={{ base: "120px", lg: "200px" }}
                        objectFit={"cover"} borderRadius={"full"}
                        onError={(e) => {
                            (e.currentTarget as HTMLImageElement).src = "https://placehold.co/300x300";
                        }} />
                </Box>
                <Text mt={3}>ニックネーム</Text>
                <Text>{user.nickname}</Text>
                <Text mt={3}>メールアドレス</Text>
                <Text>{user.email}</Text>
                <Text mt={3}>生年月日</Text>
                <Text>{user?.birthday ?? "登録なし"}</Text>
                <Text mt={3}>{user.gender === 1 ? "男性" : "女性"}</Text>
            </VStack>
            <HStack justifyContent={"center"} my={5}>
                <Button
                    as={Link}
                    href={"/edit"}
                    mr={{base:2, md:5}}
                    fontWeight={"bold"}
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                    w={{ md: "150px" }}
                >
                    編集
                </Button>
                <Button
                    onClick={() => { onOpen() }}
                    // mt={5}
                    fontWeight={"bold"}
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                    w={{ md: "150px" }}
                >
                    削除
                </Button>
            </HStack>
        </Box >
    );
}

Profile.layout = (page: React.ReactNode) => (
    <MainLayout title="プロフィール">{page}</MainLayout>
);
export default Profile;
