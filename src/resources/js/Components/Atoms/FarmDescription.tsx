import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmDescriptionProps = {
    description: string;
}

const FarmDescription = ({ description }: FarmDescriptionProps) => {
    return (
        <Text whiteSpace="pre-wrap">{description}</Text>
    );
};

export default FarmDescription;
