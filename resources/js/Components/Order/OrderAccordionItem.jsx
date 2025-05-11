import { useState } from 'react';
import { ChevronDown } from 'lucide-react';

const AccordionItem = ({ title, children, defaultOpen = false }) => {
    const [isOpen, setIsOpen] = useState(defaultOpen);

    return (
        <div className="bg-gray-100 border border-gray-100">
            <button
                onClick={() => setIsOpen(!isOpen)}
                className="w-full flex items-center justify-between p-3 cursor-pointer font-medium"
            >
                    <span className='text-[#333]'>{title}</span>

                    <ChevronDown size={20} className={`text-gray-300 transform transition-transform duration-200 ${ isOpen ? 'rotate-180' : '' }`} />
            </button>

            {
                isOpen && (
                    <div className="border border-gray-100 bg-white text-sm">
                        {children}
                    </div>
                )
            }
        </div>
    );
};

export default AccordionItem;
