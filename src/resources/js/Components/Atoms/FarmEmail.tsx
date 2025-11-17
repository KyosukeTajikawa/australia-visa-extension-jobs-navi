import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmEmailProps = {
    email: string | undefined;
}

const FarmEmail = ({ email }: FarmEmailProps) => {
    return (
        <Text mb={1}>
            メールアドレス：{email ? email : "登録なし"}
        </Text>
    );
};

export default FarmEmail;
