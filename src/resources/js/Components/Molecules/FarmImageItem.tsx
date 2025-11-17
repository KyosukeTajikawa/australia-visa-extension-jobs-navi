import React from 'react';
import { Box } from '@chakra-ui/react';
import FarmImage from '../Atoms/FarmImage';

type Farm_image = {
    id: number;
    url: string;
};

type Farm = {
    id: number;
    name: string;
    images?: Farm_image[];
};

type FarmImageItemProps = {
    farmImage: Farm_image;
    farm: Farm;
}


const FarmImageItem = ({ farmImage, farm }: FarmImageItemProps) => {
    return (
        <Box
            p={4}
            w={{ base: "90%", md: "48%", xl: "45%" }}
            mx={"auto"}
        >
            <FarmImage url={farmImage.url} name={farm.name} />
        </Box>
    );
}

export default FarmImageItem;
