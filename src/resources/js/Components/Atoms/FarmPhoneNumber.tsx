import React from 'react';
import { Text } from '@chakra-ui/react';

type FarmPhoneNumberProps = {
    phone_number: string | undefined;
}

const FarmPhoneNumber = ({ phone_number }: FarmPhoneNumberProps) => {
    return (
        <Text mb={1}>
            電話番号：{phone_number ? phone_number : "登録なし"}
        </Text>
    );
};

export default FarmPhoneNumber;
