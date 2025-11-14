import React from "react";
import MainLayout from "@/Layouts/MainLayout";
import { Box, Heading, Text, VStack, Button, Image, AlertDialog, AlertDialogBody, AlertDialogFooter, AlertDialogHeader, AlertDialogContent, AlertDialogOverlay, useDisclosure } from "@chakra-ui/react";
import { Link, router } from "@inertiajs/react";

type UserImage = {
    id: number;
    user_id: number;
    url: string;
}

type User = {
    id: number;
    nickname: string;
    gender: number | null;
    birthday?: string | "";
    email: string;
};

type ProfileProps = {
    user: User;
    user_image: UserImage | null;
}

const Profile = ({ user, user_image }: ProfileProps) => {
    const { isOpen, onOpen, onClose } = useDisclosure()
    const cancelRef = React.useRef<HTMLButtonElement>(null)

    return (

        <Box w={{ base: "90%", md: "60%" }} mx={"auto"} mt={"150px"}>

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
                    <Image src={user_image?.url ?? "/images/default_avatar.png"} h={{ base: "200px", sm: "300px", md: "200px", xl: "300px" }}
                        objectFit={"cover"} borderRadius={"full"}
                        onError={(e) => {
                            (e.currentTarget as HTMLImageElement).src = "https://placehold.co/300x300";
                        }} />
                </Box>
                <Text>ニックネーム</Text>
                <Text>{user.nickname}</Text>
                <Text>メールアドレス</Text>
                <Text>{user.email}</Text>
                <Text>性別</Text>
                <Text>{user.gender === 1 ? "男性" : "女性"}</Text>
                <Text>生年月日</Text>
                <Text>{user?.birthday ?? "登録なし"}</Text>
            </VStack>
            <VStack>
                <Button
                    as={Link}
                    href={"/edit"}
                    mt={2}
                    fontWeight={"normal"}
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                >
                    編集
                </Button>
                <Button
                    onClick={() => { onOpen() }}
                    mt={2}
                    fontWeight={"normal"}
                    bg="green.800"
                    _hover={{ bg: "green.700", textDecoration: "none" }}
                    color="white"
                >
                    削除
                </Button>
            </VStack>


        </Box >
    );
}

Profile.layout = (page: React.ReactNode) => (
    <MainLayout title="プロフィール">{page}</MainLayout>
);
export default Profile;
