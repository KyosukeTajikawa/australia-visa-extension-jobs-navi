import React from 'react';
import { Box } from '@chakra-ui/react';
import DummyFarmImage from '../Atoms/DummyFarmImage';

type Farm = {
    id: number;
    name: string;
};

type DummyFarmImageItemProps = {
    farm: Farm;
}

const DummyFarmImageItem = ({ farm }: DummyFarmImageItemProps) => {
    return (
        <Box
            p={4}
            w={{ base: "90%", md: "48%", xl: "45%" }}
            mx={"auto"}
        >
            <DummyFarmImage name={farm.name} />
        </Box>
    );
}

export default DummyFarmImageItem;
