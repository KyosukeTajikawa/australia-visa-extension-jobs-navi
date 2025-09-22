import React from "react";
import {
    Box, Heading, VStack, HStack, Image, Text, Link, Input, Button, Menu, MenuButton, MenuList, MenuItem, IconButton, Drawer,
    DrawerBody, DrawerOverlay, DrawerContent, DrawerCloseButton, useDisclosure
} from "@chakra-ui/react";
import { HamburgerIcon } from '@chakra-ui/icons';
import MainLayout from "@/Layouts/MainLayout";

type Farm = {
    id: number;
    name: string;
    description: string;
};

type Props = {
    farms: Farm[]
};

const Home = ({ farms }) => {
    const { isOpen, onOpen, onClose } = useDisclosure()
    return (

        <Box m={2}>
            {/* ヘッダー */}
            {/* <Box bg={"green.500"} p={"4px"} mb={2} display={"flex"} justifyContent={"space-between"} alignItems={"center"}>
                <Heading as={"h1"} color={"white"} fontSize={{ base: "24px", md: "30px", lg: "40px" }}>ファーム一覧</Heading> */}
                {/* SPメニュー */}
                {/* <Box display={{ base: "block", md: "none" }}>
                    <Menu>
                        <MenuButton as={IconButton} aria-label="Options" icon={<HamburgerIcon color={"white"} />} variant={"ghost"} _hover={{ bg: "green.300" }} _active={{ bg: "green.300" }} />
                        <MenuList>
                            <MenuItem>ログイン</MenuItem>
                            <MenuItem>新規登録</MenuItem>
                        </MenuList>
                    </Menu>
                </Box> */}
                {/* PCメニュー */}
                {/* <Box display={{ base: "none", md: "block" }}>
                    <Button colorScheme='teal' onClick={onOpen} bg={"green.500"} _hover={{ bg: "green.300" }}>
                        <HamburgerIcon />
                    </Button>
                    <Drawer isOpen={isOpen} onClose={onClose}>
                        <DrawerOverlay />
                        <DrawerContent>
                            <DrawerCloseButton />
                            <DrawerBody mt={"60px"} align={"center"} w={"100%"}>
                                <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                    <Link _hover={{ color: "none" }}>
                                        <Text>ログイン</Text>
                                    </Link>
                                </Box>
                                <Box mb={1} _hover={{ opacity: 0.7, bg: "gray.100" }}>
                                    <Link _hover={{ color: "none" }}>
                                        <Text>新規登録</Text>
                                    </Link>
                                </Box>
                            </DrawerBody>
                        </DrawerContent>
                    </Drawer>
                </Box>
            </Box> */}
            {/* ファーム一覧 */}
            <VStack spacing={4} align={"stretch"}>
                {farms.map((farm) => (
                    <Link key={farm.id} href={`/farm/${farm.id}`} _hover={{ color: "gray.500" }}>
                        <Box p={4} border={"1px solid"} borderColor={"gray.300"} borderRadius={"md"} boxShadow={"md"}>
                            <HStack>
                                <Image src="https://placehold.co/100x100" boxSize={"100px"} objectFit={"cover"} alt={farm.name} />
                                <VStack align={"stretch"}>
                                    <Heading as={"h3"}>{farm.name}</Heading>
                                    <Text>{farm.description}</Text>
                                </VStack>
                            </HStack>
                        </Box>
                    </Link>
                ))}
            </VStack>
            {/* Footer */}
            {/* <Box>
                <Box bg="green.500" color={"white"} fontWeight={"bold"} textAlign={"center"} py={{ base: 2, md: 3 }}>
                    <Text fontSize={{ base: 13, md: 16 }}>&copy; 2025 ファーム攻略サイト</Text>
                </Box>
            </Box > */}
        </Box >
    );
};

Home.layout = page => <MainLayout children={page} title="ファーム情報サイト" />
export default Home;
