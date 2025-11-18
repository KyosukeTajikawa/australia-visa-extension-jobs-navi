import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmSuburbProps = {
    suburb: string;
}

const FarmSuburb = ({ suburb }: FarmSuburbProps) => {
    return (
        <Text>{suburb}</Text>
    );
};

export default FarmSuburb;
