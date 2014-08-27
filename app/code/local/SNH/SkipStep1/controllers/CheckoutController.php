<?php

class SNH_SkipStep1_CheckoutController extends Mage_Core_Controller_Front_Action
{
    public function forgotPasswordPostAction()
    {
        $email = (string) $this->getRequest()->getPost('email');
        $session = Mage::getSingleton('customer/session');
        
        if ($email) {
            if (!Zend_Validate::is($email, 'EmailAddress')) {
                $session->setForgottenEmail($email);
                $session->addError($this->__('Invalid email address.'));
                $this->_redirect('checkout/onepage');
                return;
            }

            /** @var $customer Mage_Customer_Model_Customer */
            $customer = Mage::getModel('customer/customer')
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByEmail($email);

            if ($customer->getId()) {
                try {
                    $new_pass = $customer->generatePassword();
                    $customer->changePassword($new_pass, false);
                    $customer->sendPasswordReminderEmail();
                        
                    /*$newResetPasswordLinkToken =  Mage::helper('customer')->generateResetPasswordLinkToken();
                    $customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
                    $customer->sendPasswordResetConfirmationEmail(); */
                    $session->addSuccess(Mage::helper('customer')->__('A new password has been sent to %s', Mage::helper('customer')->escapeHtml($email)));
                    $this->_redirect('checkout/onepage');
                    return;
                } catch (Exception $exception) {
                    $session->addError($exception->getMessage());
                    $this->_redirect('checkout/onepage');
                    return;
                }
            }
            else {
                $session->addError($this->__("This email address was not found."));
                $this->_redirect('checkout/onepage');
                return;
            }
        } else {
            $this->$session->addError($this->__('Please enter your email.'));
            $this->_redirect('checkout/onepage');
            return;
        }
    }
}
