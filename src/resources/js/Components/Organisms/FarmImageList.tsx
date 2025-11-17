import React from 'react';
import { Box, Flex } from '@chakra-ui/react';
import FarmImageItem from '../Molecules/FarmImageItem';
import DummyFarmImageItem from '../Molecules/DummyFarmImageItem';

type Farm_image = {
    id: number;
    url: string;
};

type Farm = {
    id: number;
    name: string;
    images?: Farm_image[];
};

type FarmImageListProps = {
    farm: Farm;
}

const FarmImageList = ({ farm }: FarmImageListProps) => {

    const farmItems: JSX.Element[] =
        farm.images && farm.images.length > 0 ?
            farm.images?.map((image) => (
                <FarmImageItem
                    key={image.id}
                    farm={farm}
                    farmImage={image}
                />
            ))
        : (
                [<DummyFarmImageItem key={"dummyImage"} farm={farm} />]
        )
        if (farmItems?.length % 2 !== 0) {
            farmItems?.push(
                <Box
                    key={"dummy"}
                    p={4}
                    w={{ base: "none", md: "48%", xl: "45%" }}
                    mb={5}
                    mx={"auto"}
                    visibility={"hidden"}
                    pointerEvents={"none"}
                ></Box>
            );
        }

    return (
        <Flex
            wrap={"wrap"}
            w={{ base: "80%", xl: "1280px" }}
            mx={"auto"}
        >
            {farmItems}
        </Flex>
    );
};

export default FarmImageList;
