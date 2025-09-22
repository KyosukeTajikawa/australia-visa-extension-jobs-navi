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
        </Box >
    );
};

Home.layout = page => <MainLayout children={page} title="ファーム情報サイト" />
export default Home;
