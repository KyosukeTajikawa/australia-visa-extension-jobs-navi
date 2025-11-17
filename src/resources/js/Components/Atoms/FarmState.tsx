import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmStateProps = {
    name: string;
}

const FarmState = ({ name }: FarmStateProps) => {
    return (
        <Text>{name}</Text>
    );
};

export default FarmState;
