import React from 'react';
import { Box, Text, HStack } from '@chakra-ui/react';
import FarmCrop from '../Atoms/FarmCrop';
import FarmPhoneNumber from '../Atoms/FarmPhoneNumber';
import FarmEmail from '../Atoms/FarmEmail';
import FarmStreetAddress from '../Atoms/FarmStreetAddress';
import FarmSuburb from '../Atoms/FarmSuburb';
import FarmState from '../Atoms/FarmState';
import FarmPostcode from '../Atoms/FarmPostcode';
import FarmDescription from '../Atoms/FarmDescription';

type Crops = {
    id: number;
    name: string;
}

type State = {
    id: number;
    name: string;
}

type Farm = {
    id: number;
    name: string;
    phone_number?: string;
    email?: string;
    description: string;
    street_address: string;
    suburb: string;
    postcode: string;
    state: State;
    crops: Crops[];
};

type FarmListProps = {
    farm: Farm;
}

const FarmList = ({ farm }: FarmListProps) => {
    return (
        <Box>
            <Box
                w={{ base: "72%", md: "78%", xl: "1220px" }}
                mx={"auto"}
                px={4}
                fontSize={"20px"}
                letterSpacing={1}
            >
                <Box
                    display={"flex"}
                    alignItems={"center"}
                >
                    取扱作物：
                    {farm.crops.map((crop) => (
                        <Box
                            key={crop.id}
                            px={2}
                            py={1}
                        >
                            <FarmCrop name={crop.name} />
                        </Box>
                    ))}
                </Box>
                <FarmPhoneNumber phone_number={farm.phone_number} />
                <FarmEmail email={farm.email} />
                <HStack mb={1}>
                    <FarmStreetAddress street_address={farm.street_address} />
                    <FarmSuburb suburb={farm.suburb} />
                    <FarmState name={farm.state.name} />
                    <FarmPostcode postcode={farm.postcode} />
                </HStack>
                <Text mb={1}>説明</Text>
                <FarmDescription description={farm.description} />
            </Box>
        </Box>
    );
}

export default FarmList;
